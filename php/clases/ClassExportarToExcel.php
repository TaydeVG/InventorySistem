<?php
include_once("../php/objetos/DataArchivoExcel.obect.php");
class ClassExportarToExcel
{
    public static function exportarExcel($conexMySql, $DataArchivoExcelRequest)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        $consultaExportacion = "";
        try {
            $encabezado = $DataArchivoExcelRequest->getEncabezado();
            $titulo_hoja = $DataArchivoExcelRequest->getTitulo_hoja();
            $nombre_archivo_excel = $DataArchivoExcelRequest->getNombre_archivo_excel();
            $columnas_bd = $DataArchivoExcelRequest->getColumnas_base_datos();
            $titulos_column = $DataArchivoExcelRequest->getTitulosColumnas();
            $tabla_base_datos = $DataArchivoExcelRequest->getTabla_base_datos();

            $consultaExportacion = "SELECT ";
            for ($i = 0; $i < count($columnas_bd); $i++) {
                if ($i == (count($columnas_bd) - 1)) { //prepara la consulta agregando una "," excepto en la ultima columna
                    $consultaExportacion .= $columnas_bd[$i] . "";
                } else {
                    $consultaExportacion .= $columnas_bd[$i] . ",";
                }
            }

            $consultaExportacion .= " FROM $tabla_base_datos ";
            if ($DataArchivoExcelRequest->getCondicionExtraerDatos()) {
                $consultaExportacion .= $DataArchivoExcelRequest->getCondicionExtraerDatos();
            }


            $consulta = $conexMySql->prepare($consultaExportacion);
            $consulta->execute();

            //while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            if ($consulta->rowCount() > 0) {
                /** Se agrega la libreria PHPExcel */
                require_once("../librerias/lib_php/PHPExcel.php");

                // Se crea el objeto PHPExcel
                $objPHPExcel = new PHPExcel();
                $_columnasEXCEL = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

                // Se asignan las propiedades del libro
                $objPHPExcel->getProperties()->setCreator("UPVE") // Nombre del autor
                    ->setLastModifiedBy("UPVE") //Ultimo usuario que lo modificó
                    ->setTitle("Reporte InventorySistem") // Titulo
                    ->setSubject("Reporte InventorySistem") //Asunto
                    ->setDescription("Reporte InventorySistem") //Descripción
                    ->setKeywords("InventorySistem") //Etiquetas
                    ->setCategory("InventorySistem"); //Categorias

                // Se agregan los titulos del reporte
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $encabezado); // Titulo del reporte
                for ($index = 0; $index <  count($titulos_column); $index++) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($_columnasEXCEL[$index] . '3',  $titulos_column[$index]);  //Titulo de las columnas
                }

                $i = 4; //Numero de fila donde se va a comenzar a rellenar
                $cont = 1;
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, " " . $cont . " ");
                    for ($index2 = 0; $index2 < count($columnas_bd); $index2++) {
                        //setCellValue('C' . $i, $fila['campo_tabla']);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($_columnasEXCEL[$index2 + 1] . $i, $fila[$columnas_bd[$index2]]);
                    }
                    $i++;
                    $cont++;
                }

                $estiloTituloReporte = ClassExportarToExcel::getEstiloTituloReporte();

                $estiloTituloColumnas = ClassExportarToExcel::getEstiloTituloColumnas();

                $estiloInformacion = new PHPExcel_Style();
                $estiloInformacion->applyFromArray(ClassExportarToExcel::getEstiloInformacion());

                //se calcula de que letra a que letra medira el titulo ejemplo de A1:C1 mediria 3 columnas de largo
                $ultima_columna = $_columnasEXCEL[count($columnas_bd)]; //obtiene la letra hasta la que llegara el encabezado

                // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $ultima_columna . '1');

                //aplica estilo al encabezado
                $objPHPExcel->getActiveSheet()->getStyle('A1:' . $ultima_columna . '1')->applyFromArray($estiloTituloReporte);
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(1)->setRowHeight(50); //cambia tamaño de alto del titulo Reporte

                //aplicacion de estilos
                $objPHPExcel->getActiveSheet()->getStyle('A3:' . $ultima_columna . '3')->applyFromArray($estiloTituloColumnas);
                $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:" . $ultima_columna . ($i - 1));

                //aplicacion para que el tamaño de columna sea automatico
                for ($i = 'A'; $i <= $ultima_columna; $i++) {
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
                }
                /*    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(FALSE); //columna B como excepcion para que no tenga el tamaño automatico
                $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(40); // se le aplica ese tamaño de ancho solo a la columna B
                */
                // Se asigna el nombre a la hoja
                $objPHPExcel->getActiveSheet()->setTitle($titulo_hoja);

                // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
                $objPHPExcel->setActiveSheetIndex(0);

                // Inmovilizar paneles
                //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
                $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

                // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $nombre_archivo_excel . '"');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');

                $datos['mensaje'] = "Exportacion exitosa!";
                $datos['resultOper'] = 1;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $consultaExportacion . ":" . $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function getEstiloInformacion()
    {
        return array(
            'font' => array(
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFd9b7f4'
                )
            ),
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'rgb' => '3a2a47'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
    }
    public static function getEstiloTituloColumnas()
    {
        return array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => true,
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' => array(
                'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
                'startcolor' => array(
                    'rgb' => 'c47cf2'
                ),
                'endcolor' => array(
                    'argb' => 'FF431a5d'
                )
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'      => TRUE
            )
        );
    }
    public static function getEstiloTituloReporte()
    {
        return array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' => 14,
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FF220835'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
    }
}
