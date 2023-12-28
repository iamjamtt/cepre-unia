<?php

namespace App\Exports\Reportes;

use App\Models\Grupo;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class PostulantesIngresantesByGrupoAndCarrera implements FromCollection, WithTitle, WithMapping,  ShouldAutoSize, WithEvents, WithCustomStartCell
{

    protected $item = 1;
    protected $ciclo_id;

    public function __construct($ciclo_id)
    {
        $this->item = 1;
        $this->ciclo_id = $ciclo_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $inscripciones = Inscripcion::join('carreras', 'carreras.id', '=', 'inscripcions.carrera_id')
            ->join('personas', 'personas.id', '=', 'inscripcions.persona_id')
            ->join('grupos', 'grupos.id', '=', 'personas.grupo_id')
            ->select(
                'grupos.nombre as grupo_nombre',
                DB::raw('SUM(CASE WHEN carreras.id = 1 THEN 1 ELSE 0 END) as inscritos_IAFA'),
                DB::raw('SUM(CASE WHEN carreras.id = 2 THEN 1 ELSE 0 END) as inscritos_IAI'),
                DB::raw('SUM(CASE WHEN carreras.id = 3 THEN 1 ELSE 0 END) as inscritos_EIB'),
                DB::raw('SUM(CASE WHEN carreras.id = 4 THEN 1 ELSE 0 END) as inscritos_EPB'),
                DB::raw('COUNT(*) as count_inscritos'),
                DB::raw('SUM(CASE WHEN carreras.id = 1 AND inscripcions.ingreso = 1 THEN 1 ELSE 0 END) as ingresantes_IAFA'),
                DB::raw('SUM(CASE WHEN carreras.id = 2 AND inscripcions.ingreso = 1 THEN 1 ELSE 0 END) as ingresantes_IAI'),
                DB::raw('SUM(CASE WHEN carreras.id = 3 AND inscripcions.ingreso = 1 THEN 1 ELSE 0 END) as ingresantes_EIB'),
                DB::raw('SUM(CASE WHEN carreras.id = 4 AND inscripcions.ingreso = 1 THEN 1 ELSE 0 END) as ingresantes_EPB'),
                DB::raw('SUM(CASE WHEN inscripcions.ingreso = 1 THEN 1 ELSE 0 END) as count_ingresantes')
            )
            ->where('personas.activo',1)
            ->where('personas.borrado',0)
            ->where('inscripcions.activo',1)
            ->where('inscripcions.borrado',0)
            ->where('ciclo_id', $this->ciclo_id)
            ->groupBy('personas.grupo_id')
            ->get();

        return $inscripciones;
    }

    public function map($inscripcion): array
	{
		return [
			$this->item++,
			$inscripcion->grupo_nombre,
			$inscripcion->inscritos_IAFA,
            $inscripcion->inscritos_IAI,
            $inscripcion->inscritos_EIB,
            $inscripcion->inscritos_EPB,
            $inscripcion->count_inscritos,
            $inscripcion->ingresantes_IAFA,
            $inscripcion->ingresantes_IAI,
            $inscripcion->ingresantes_EIB,
            $inscripcion->ingresantes_EPB,
            $inscripcion->count_ingresantes,
		];
	}

    public function registerEvents(): array
	{
		return [
			BeforeExport::class => function(BeforeExport $event) {
				$event->writer->getProperties()->setCreator('CEPRE UNIA');
				$event->writer->getProperties()->setTitle("Listado de Postulantes e Ingresantes por Grupo Etnico y Carreras");
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

				$event->sheet->setCellValue('A1', 'LISTADO DE POSTULANTES E INGRESANTES POR GRUPO ETNICO Y CARRERAS');
				$event->sheet->getDelegate()->getStyle('A1:L1')->applyFromArray($tamanio);
				$event->sheet->getDelegate()->getStyle('A1:L1')->applyFromArray($negrita);
				$event->sheet->getDelegate()->mergeCells('A1:L1');
				$event->sheet->getDelegate()->getStyle('A1:L1')->applyFromArray($centrar);

				// Primera fila de encabezados con las categorías principales
                $columnas1 = ['NRO', 'PUEBLO ORIGINARIO', 'POSTULANTES', '', '', '', '', 'INGRESANTES', '', '', '', ''];
                $event->sheet->getDelegate()->fromArray($columnas1, NULL, 'A3');
                $event->sheet->getDelegate()->mergeCells('C3:G3'); // Fusiona para 'POSTULANTES'
                $event->sheet->getDelegate()->mergeCells('H3:L3'); // Fusiona para 'INGRESANTES'

                // Segunda fila de encabezados con los nombres de las carreras y 'TOTAL'
                $columnas2 = ['', '', 'IAFA', 'IAI', 'EIB', 'EPB', 'TOTAL', 'IAFA', 'IAI', 'EIB', 'EPB', 'TOTAL'];
                $event->sheet->getDelegate()->fromArray($columnas2, NULL, 'A4');
                $event->sheet->getDelegate()->mergeCells('A3:A4'); // Fusiona para 'NRO'
                $event->sheet->getDelegate()->mergeCells('B3:B4'); // Fusiona para 'PUEBLO ORIGINARIO'

				$event->sheet->getDelegate()->getStyle('A3:L3')->applyFromArray($header);
				$event->sheet->getDelegate()->getStyle('A3:L3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
                $event->sheet->getDelegate()->getStyle('A3:L3')->applyFromArray($centrar);
                $event->sheet->getDelegate()->getStyle('A3:L3')->applyFromArray($border);
                $event->sheet->getDelegate()->getStyle('A4:L4')->applyFromArray($header);
				$event->sheet->getDelegate()->getStyle('A4:L4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
                $event->sheet->getDelegate()->getStyle('A4:L4')->applyFromArray($centrar);
                $event->sheet->getDelegate()->getStyle('A4:L4')->applyFromArray($border);
				for ($i=1; $i <= $this->item ; $i++) {
					$event->sheet->getDelegate()->getStyle('A'.($i+3))->applyFromArray($negrita);
					$event->sheet->getDelegate()->getStyle('G'.($i+3))->applyFromArray($negrita);
					$event->sheet->getDelegate()->getStyle('L'.($i+3))->applyFromArray($negrita);
					$event->sheet->getDelegate()->getStyle('A'.($i+3).':L'.($i+3))->applyFromArray($border);
					$event->sheet->getDelegate()->getStyle('A'.($i+3).':A'.($i+3))->applyFromArray($centrar);
					$event->sheet->getDelegate()->getStyle('C'.($i+3).':L'.($i+3))->applyFromArray($centrar);
                    $event->sheet->getDelegate()->getStyle('G'.($i+3))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
                    $event->sheet->getDelegate()->getStyle('L'.($i+3))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
				}

                // Agregar la ultima fila con los totales
                $event->sheet->setCellValue('B'.($this->item+4), 'TOTAL');
                $event->sheet->setCellValue('C'.($this->item+4), '=SUM(C5:C'.($this->item+3).')');
                $event->sheet->setCellValue('D'.($this->item+4), '=SUM(D5:D'.($this->item+3).')');
                $event->sheet->setCellValue('E'.($this->item+4), '=SUM(E5:E'.($this->item+3).')');
                $event->sheet->setCellValue('F'.($this->item+4), '=SUM(F5:F'.($this->item+3).')');
                $event->sheet->setCellValue('G'.($this->item+4), '=SUM(G5:G'.($this->item+3).')');
                $event->sheet->setCellValue('H'.($this->item+4), '=SUM(H5:H'.($this->item+3).')');
                $event->sheet->setCellValue('I'.($this->item+4), '=SUM(I5:I'.($this->item+3).')');
                $event->sheet->setCellValue('J'.($this->item+4), '=SUM(J5:J'.($this->item+3).')');
                $event->sheet->setCellValue('K'.($this->item+4), '=SUM(K5:K'.($this->item+3).')');
                $event->sheet->setCellValue('L'.($this->item+4), '=SUM(L5:L'.($this->item+3).')');
                $event->sheet->getDelegate()->getStyle('A'.($this->item+4).':L'.($this->item+4))->applyFromArray($negrita);
                $event->sheet->getDelegate()->getStyle('A'.($this->item+4).':L'.($this->item+4))->applyFromArray($border);
                $event->sheet->getDelegate()->getStyle('C'.($this->item+4).':L'.($this->item+4))->applyFromArray($centrar);
				$event->sheet->getDelegate()->getStyle('A'.($this->item+4).':L'.($this->item+4))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99a3a4');
			},
		];
	}

    public function startCell(): string
	{
		return 'A5';
	}

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Postulantes e Ingresantes por Grupo Etnico y Carreras';
    }
}
