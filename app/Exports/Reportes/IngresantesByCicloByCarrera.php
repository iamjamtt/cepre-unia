<?php

namespace App\Exports\Reportes;

use App\Helpers\HelpersUnia;
use App\Models\Carrera;
use App\Models\Ciclo;
use App\Models\Inscripcion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class IngresantesByCicloByCarrera implements FromCollection, WithTitle, WithMapping, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    private $item;
    private $ciclo;
    private $carrera;

    public function __construct($ciclo_id, $carrera_id)
    {
        $this->item = 1;
        $this->ciclo = Ciclo::find($ciclo_id);
        $this->carrera = Carrera::find($carrera_id);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ingresantes = Inscripcion::where('ciclo_id', $this->ciclo->id)
            ->where('carrera_id', $this->carrera->id)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->orderBy('puntaje','desc')
            ->get();

        return $ingresantes;
    }

    public function map($ingresante): array
	{
		return [
			$this->item++,
			$ingresante->persona->dni,
			$ingresante->persona->apePaterno . ' ' . $ingresante->persona->apeMaterno,
			$ingresante->persona->nombres,
			$ingresante->persona->celular,
			$ingresante->persona->celular_apoderado ?? '-',
			HelpersUnia::convertirFecha($ingresante->persona->fechaNac),
            HelpersUnia::getSexo($ingresante->persona->sexo),
			$ingresante->carrera->nombre,
			$ingresante->persona->distrito->provincia->departamento->nombre,
			$ingresante->persona->distrito->provincia->nombre,
			$ingresante->persona->distrito->nombre,
			$ingresante->persona->grupo->nombre,
			$ingresante->persona->comunidad ?? '-',
            $ingresante->persona->user->email ?? '-',
            $ingresante->puntaje,
            $ingresante->ingreso ? 'INGRESO' : 'NO INGRESO',
		];
	}

    public function registerEvents(): array
	{
		return [
			BeforeExport::class => function(BeforeExport $event) {
				$event->writer->getProperties()->setCreator('CEPRE UNIA');
				$event->writer->getProperties()->setTitle("Listado de Ingresantes de la CEPRE UNIA " . $this->ciclo->nombre . " - " . $this->carrera->nombre);
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

				$event->sheet->setCellValue('A1', 'LISTADO DE INGRESANTES DEL CEPRE UNIA ' . $this->ciclo->nombre . ' - ' . $this->carrera->nombre);
				$event->sheet->getDelegate()->getStyle('A1:Q1')->applyFromArray($tamanio);
				$event->sheet->getDelegate()->getStyle('A1:Q1')->applyFromArray($negrita);
				$event->sheet->getDelegate()->mergeCells('A1:Q1');
				$event->sheet->getDelegate()->getStyle('A1:Q1')->applyFromArray($centrar);

				$columnas = ['N°','DNI','APELLIDOS','NOMBRES','WHATSAPP','LLAMADAS','FECHA NAC.','SEXO','CARRERA PROFESIONAL','DEPARTAMENTO','PROVINCIA','DISTRITO','GRUPO','COMUNIDAD','CORREO','PUNTAJE','CONDICIÓN'];
				$event->sheet->getDelegate()->fromArray($columnas, NULL, 'A3');

				$event->sheet->getDelegate()->getStyle('A3:Q3')->applyFromArray($header);
				$event->sheet->getDelegate()->getStyle('A3:Q3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
				for ($i=1; $i <= $this->item ; $i++) {
					$event->sheet->getDelegate()->getStyle('A'.($i+2))->applyFromArray($negrita);
					$event->sheet->getDelegate()->getStyle('A'.($i+2).':Q'.($i+2))->applyFromArray($border);
					$event->sheet->getDelegate()->getStyle('A'.($i+2).':B'.($i+2))->applyFromArray($centrar);
					$event->sheet->getDelegate()->getStyle('E'.($i+2).':G'.($i+2))->applyFromArray($centrar);
					$event->sheet->getDelegate()->getStyle('P'.($i+2).':Q'.($i+2))->applyFromArray($centrar);
				}
			},
		];
	}

	public function startCell(): string
	{
		return 'A4';
	}

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->carrera->nombre;
    }
}
