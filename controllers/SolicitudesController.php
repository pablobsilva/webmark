<?php

require_once 'Controller.php';

class SolicitudesController extends Controller 

{

    public function __construct()
    {
        $this->middleware('login');
    }

    public function verDistribuidores()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $distribuidores = $db->prepare(
            'SELECT * FROM distribuidores'
        );
        $distribuidores->execute();
        $distribuidores = $distribuidores->fetchAll();
        if($distribuidores)
        {
            echo json_encode(array(
                'distribuidores' => $distribuidores,
                'resultado' => true,
            ));
        }
        else
        {
            echo json_encode(array(
                'resultado' => false,
                'mensaje_error' => "error al eliminar"
            ));
        }
    }

    public function exportExcel()
    {
        require_once '../classes/PHPExcel.php';
        require_once '../classes/Conexion.php';
        $objPHPExcel = new PHPExcel();
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $fecha = $data->fecha;
        if(!isset($fecha))
        {
            $ventas = $db->prepare('SELECT * FROM ventas');
            $ventas->execute();
            $ventas = $ventas->fetchAll();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'N°');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Hora');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Fecha');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Total');

            $rowCount = 2; //new
            $indice = 1;

            foreach($ventas as $venta){ 
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $indice); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $venta->hora); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $venta->fecha);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $venta->total); 
                // Increment the Excel row counter
                $rowCount++;
                $indice++; 
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Ventas');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Export_Excel_'.date('Y-m-d').'.xls"');
            //header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            //$data['blob']=$objWriter;
            echo json_encode(array(
                'excel' => $objWriter
            ));
            //exit;
        }

    }

    public function RegistrarPago()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $pago = $data->pago;
        $fecha = date('Y-m-d', time());
        $hora = date('H:i:s', time());
        $insert = $db->prepare(
            'INSERT INTO pagos
            (
                fecha, hora, rut_trabajador, rut_empresa, monto
            )    
            VALUES
            (
                :fecha, :hora, :rut_trabajador, :rut_empresa, :total
        )');
        $insert = $insert->execute(array(
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':rut_trabajador' => $data->rut,
            ':rut_empresa' => $data->rut_empresa,
            ':total' => $pago->monto,
        ));
        if($insert)
        {
            echo json_encode(array(
                'respuesta' => true,
                'mensaje' => "Agregado exitosamente"
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false,
                'mensaje' => "Error al registrar pago"
            ));
        }
    }

    public function verPagosDia()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $fecha = date('Y-m-d', time());
        $pagos = $db->prepare(
            "SELECT p.fecha, p.hora, p.rut_trabajador, p.descripcion, p.monto, pr.nombre as nombre 
            FROM pagos p 
            INNER JOIN personal pr 
                ON p.rut_trabajador = pr.rut 
            WHERE p.rut_empresa = :rut_empresa AND fecha = :fecha"
        );
        $pagos->execute(array(
            ':rut_empresa' => $data->rut_empresa,
            ':fecha' => $fecha
        ));
        $pagos = $pagos->fetchAll();
        if($pagos)
        {
            echo json_encode(array(
                'pagos' => $pagos,
            ));
        }
        else
        {
            echo json_encode(array(
                'pagos' => false,
            ));
        }
    }
}