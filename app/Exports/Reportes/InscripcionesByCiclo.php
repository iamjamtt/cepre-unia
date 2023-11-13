<?php

namespace App\Exports\Reportes;

use App\Helpers\HelpersUnia;
use App\Models\Ciclo;
use App\Models\Persona;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class InscripcionesByCiclo implements FromCollection, WithMapping, ShouldAutoSize, WithTitle, WithEvents, WithCustomStartCell
{
    use Exportable;
    private $item;
    private $ciclo;

    /**
     * @param string $item
     * @param string $ciclo
     */
    public function __construct($ciclo_id) {
		$this->item = 1;
        $this->ciclo = Ciclo::find($ciclo_id);
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $inscritos = Persona::join('distritos','distritos.id','=','personas.distrito_id')
			->join('provincias','provincias.id','=','distritos.provincia_id')
			->join('departamentos','departamentos.id','=','provincias.departamento_id')
			->join('inscripcions','inscripcions.persona_id','=','personas.id')
			->join('carreras','carreras.id','=','inscripcions.carrera_id')
			->join('grupos','grupos.id','=','personas.grupo_id')
			->join('users','users.persona_id','=','personas.id')
			->where('personas.activo',1)
			->where('personas.borrado',0)
			->where('users.activo',1)
			->where('users.borrado',0)
			->where('inscripcions.activo',1)
			->where('inscripcions.borrado',0)
			->where('inscripcions.ciclo_id', $this->ciclo->id)
			->orderBy('inscripcions.updated_at','DESC')
			->select('personas.dni','personas.apePaterno as apellido_paterno','personas.apeMaterno as apellido_materno','personas.nombres','personas.celular','personas.celularApoderado as celular_apoderado','personas.fechaNac as fecha_nacimiento','personas.sexo','personas.comunidad','carreras.nombre as carrera', 'departamentos.nombre as departamento','provincias.nombre as provincia','distritos.nombre as distrito','grupos.nombre as grupo','users.email')->get();

        $inscritos->map(function($inscrito) {
            $inscrito->fecha_nacimiento = HelpersUnia::convertirFecha($inscrito->fecha_nacimiento);
            $inscrito->sexo = $inscrito->sexo == 'M' ? 'MASCULINO' : 'FEMENINO';
        });

        $inscritos = $inscritos->sortBy('apellido_paterno');

        return $inscritos;
    }

    public function map($inscritos): array
	{
		return [
			$this->item++,
			$inscritos->dni,
			$inscritos->apellido_paterno.' '.$inscritos->apellido_materno,
			$inscritos->nombres,
			$inscritos->celular,
			$inscritos->celular_apoderado ?? '-',
			$inscritos->fecha_nacimiento,
			$inscritos->sexo,
			$inscritos->carrera,
			$inscritos->departamento,
			$inscritos->provincia,
			$inscritos->distrito,
			$inscritos->grupo,
			$inscritos->comunidad ?? '-',
            $inscritos->email ?? '-',
		];
	}

    public function registerEvents(): array
	{
		return [
			BeforeExport::class => function(BeforeExport $event) {
				$event->writer->getProperties()->setCreator('CEPRE UNIA');
				$event->writer->getProperties()->setTitle("Listado de Inscritos del CEPRE UNIA ".$this->ciclo->nombre );

			},
			AfterSheet::class => function(AfterSheet $event) {

				$negrita = [
					'font' => [
						'bold' => true,
					],
				];
				$header = [
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
					'font' => [
						'bold' => true,
					],
				];
				$centrar = [
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					]
				];
				$italic = [
					'font' => [
						'italic' => true,
					]
				];
				$tamanio = [
					'font' => [
						'size' => 14,
					]
				];
				$border = [
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						],
					],
				];

				$event->sheet->setCellValue('A1', 'LISTADO DE POSTULANTES DEL CEPRE UNIA '.$this->ciclo->nombre);
				$event->sheet->getDelegate()->getStyle('A1:O1')->applyFromArray($tamanio);
				$event->sheet->getDelegate()->getStyle('A1:O1')->applyFromArray($negrita);
				$event->sheet->getDelegate()->mergeCells('A1:O1');
				$event->sheet->getDelegate()->getStyle('A1:O1')->applyFromArray($centrar);

				$columnas = ['N°','DNI','APELLIDOS','NOMBRES','WHATSAPP','LLAMADAS','FECHA NAC.','SEXO','CARRERA PROFESIONAL','DEPARTAMENTO','PROVINCIA','DISTRITO','GRUPO','COMUNIDAD','CORREO'];
				$event->sheet->getDelegate() ->fromArray($columnas, NULL, 'A3');

				$event->sheet->getDelegate()->getStyle('A3:O3')->applyFromArray($header);
				$event->sheet->getDelegate()->getStyle('A3:O3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
				for ($i=1; $i <= $this->item ; $i++) {
					$event->sheet->getDelegate()->getStyle('A'.($i+2))->applyFromArray($negrita);
					$event->sheet->getDelegate()->getStyle('A'.($i+2).':O'.($i+2))->applyFromArray($border);
					$event->sheet->getDelegate()->getStyle('A'.($i+2).':B'.($i+2))->applyFromArray($centrar);
					$event->sheet->getDelegate()->getStyle('E'.($i+2).':G'.($i+2))->applyFromArray($centrar);
				}
			},
		];
	}

	public function startCell(): string
	{
		return 'A4';
	}

	public function title(): string
	{
		return 'Listado de Postulantes';
	}
}
