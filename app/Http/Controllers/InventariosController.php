<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Medicamento;
use App\InventariosDesposte;
use App\InventariosMedicamento;
use App\ConceptoNomina;
use App\informacion_colaborador;
use App\SaldosCalidad;
use App\productos_calidad;
use App\ExistenciaMedicamento;
use App\VentasDesposte;
use DB;
use App\ValorFinalInventarioMtp;
use Maatwebsite\Excel\Facades\Excel;

class InventariosController extends Controller
{

	public $excel;

    public function __construct()
    {
        $this->middleware('auth');
    }

    //** Este metodo permite retornar la vista de inventario con la informacion solicitada*/
    public function ingresarInventario(Request $request)
    {
    	$flag = false;  
    	return view('admin.inventario.ingresar_inventario', compact('flag', $flag, 'request', $request));
    }

    //** Este metodo permite leer y almacenar el $request(peticion) el cual es un archivo con extension .xlsx a un directorio del servidor y despues pasar el nombre del archivo como parametro a otra funcion y realizar una funcion dependiendo del tipo_inventario de el $request(peticion)*/
    public function store(Request $request)
    {
        if($request->hasFile('file'))
        {
            $path = time().'.'. $request->file('file')->getClientOriginalExtension();
            $name = $request->file('file')->move('./../storage/app/', $path);
            $this->leer($name);
        }
        else
        {
            $flag = false;
            flash('<strong>No se reconoce el archivo</strong>!!!')->error()->important();
            return view('admin.inventario.ingresar_inventario', compact('flag', $flag));
        }

        $value = $request->tipo_inventario;
        switch ($value) 
        {
            case "desposte":
                foreach ($this->excel as $row)
                {
                    $ID = new InventariosDesposte();
                    $ID['codigo'] = $row->codigo;
                    $ID['descripcion'] = $row->descripcion;
                    $ID['kilos'] = $row->kilos;
                    $ID['unidad'] = $row->unidad;
                    $ID['costo_unitario'] = $row->costo_unitario;
                    $ID['costo_toal'] = $row->costo_total;
                    $ID['fecha'] = $row->fecha;
                    $ID->save();
                }
                flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                $flag  = true;
                return view('admin.inventario.ingresar_inventario', compact('flag', $flag));
                break;
            
            case "medicamentos":
                // echo ($this->excel);
                foreach ($this->excel as $row)
                    {
                    $IM = new InventariosMedicamento();
                    $IM['codigo'] = $row->codigo;
                    $IM['descripcion'] = $row->descripcion;
                    $IM['cantidad'] = $row->cantidad;
                    $IM['unidad'] = $row->unidad;
                    $IM['costo_unitario'] = $row->costo_unitario;
                    $IM['costo_total'] = $row->costo_total;
                    $IM['fecha'] = $row->fecha;
                    $IM->save();
                }
                flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                $flag = true;
                return view('admin.inventario.ingresar_inventario')->with($flag);
                break;

            case "calidad": 
                $ProductosCalidad = productos_calidad::All();
                for($i = 0; $i < count($ProductosCalidad); $i++ ) {
                    foreach ($this->excel as $row) {
                        if ($ProductosCalidad[$i]->codigo_producto == $row->producto) {
                            $SC = new SaldosCalidad();
                            $SC['producto_id'] = $ProductosCalidad[$i]->id;
                            $SC['descripcion'] = $row->descripcion;
                            $SC['cantidad'] = $row->cantidad;
                            $SC['unidad'] = $row->und;
                            $SC['costo_unitario'] = $row->costo_unitario;
                            $SC['total'] = $row->total;
                            $SC['fecha'] = $row->fecha;
                            $SC->save();
                            flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                            $flag = true;
                            return view('admin.inventario.ingresar_inventario')->with($flag);
                        }  
                        else if($ProductosCalidad[$i]->codigo_producto !== $row->producto) 
                            {
                                flash('<strong>El producto con el nombre: ' . $row->descripcion . " no se pudo procesar</strong>!!!")->error()->important();
                                $flag = false;
                                return view('admin.inventario.ingresar_inventario')->with($flag);
                            }
                     }
                }
                flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                $flag = true;
                return view('admin.inventario.ingresar_inventario')->with($flag);

                break;
            case "existenciaMedicamentos": 
                $Medicamentos= Medicamento::All();
                for($i = 0; $i < count($Medicamentos); $i++)  
                {
                    foreach ($this->excel as $row) {
                        if($Medicamentos[$i]->ref_medicamento == $row->producto) 
                        {
                            $EM = new ExistenciaMedicamento();
                            $EM['ref_producto'] = $row->producto;
                            $EM['descripcion'] = $row->descripcion;
                            $EM['cantidad'] = $row->cantidad;
                            $EM['medicamento_id'] = $Medicamentos[$i]->id;
                            $EM['fecha'] = $row->fecha;
                            $EM->save();
                             flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                             $flag = true;
                            return view('admin.inventario.ingresar_inventario')->with($flag);
                        }  else if($ProductosCalidad[$i]->codigo_producto !== $row->producto) 
                            {
                                flash('<strong>El producto con el nombre: ' . $row->descripcion . " no se pudo procesar</strong>!!!")->error()->important();
                                $flag = false;
                                return view('admin.inventario.ingresar_inventario')->with($flag);
                            }
                    }
                }
               
                break;
            case "colaboradores";
                foreach ($this->excel as $row)
                {
                    $IC = new informacion_colaborador();
                    $IC['empleado'] = $row->empleado;
                    $IC['cedula'] = $row->cedula;
                    $IC['nombre'] = $row->nombre;
                    $IC['fecha_ingreso'] = $row->fecha_ingreso;
                    $IC['fondo_pensiones'] = $row->fondo_pensiones;
                    $IC['nombre_de_fondo_de_pensiones'] = $row->nombre_de_fondo_de_pensiones;
                    $IC['eps'] = $row->eps;
                    $IC['nombre_de_eps'] = $row->nombre_de_eps;
                    $IC['caja_compensacion'] = $row->caja_compensacion;
                    $IC['nombre_de_caja_compensacion'] = $row->nombre_de_caja_compensacion;
                    $IC['descripcion_cargo'] = $row->descripcion_cargo;
                    $IC['descripcion_centro_costo'] = $row->descripcion_centro_costo;
                    $IC['comisiones'] = $row->comisiones;
                    $IC->save();
                }
                $flag = true;
                flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                return view('admin.inventario.ingresar_inventario')->with($flag);
                break; 

         case "ventasDesposte";
                foreach ($this->excel as $row)
                {
                    $VD = new VentasDesposte();
                    $VD['codigo'] = $row->codigo;
                    $VD['producto'] = $row->producto;
                    $VD['cantidad'] = $row->cantidad;
                    $VD['precio_total'] = $row->precio_total;
                    $VD['fecha'] = $row->fecha;
                    $VD->save();
                }
                $flag = true;
                flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                return view('admin.inventario.ingresar_inventario')->with($flag);
                break; 


        case "valorInventario";
                foreach ($this->excel as $row)
                {
                    $VFI = new ValorFinalInventarioMtp();
                    $VFI['referencia'] = $row->referencia;
                    $VFI['tipo_producto'] = $row->tipo_producto;
                    $VFI['producto'] = $row->producto;
                    $VFI['costo'] = $row->costo;
                    $VFI['mes'] = $row->mes;
                    $VFI['fecha'] = $row->fecha;
                    $VFI->save();
                }
                $flag = true;
                flash('<strong>Se proceso correctamente</strong>!!!')->success()->important();
                return view('admin.inventario.ingresar_inventario')->with($flag);
                break; 
            default:
                $flag = false;
                flash('<strong>Se ha producido un error</strong>!!!')->error()->important();
                return view('admin.inventario.ingresar_inventario')->with($flag);
                break;
        }
    }

    //** Este metodo recibe el nombre de el archivo como parametro de otra funcion para ser leido y procesado en sus respectivas filas y columnas.*/
    private function leer($name)
    {
        Excel::load($name, function ($reader)
        {
            $this->excel = $reader->get();
            return $this->excel;
        });
    }

    //** Este metodo permite llamar un archivo del servidor con formato xlsx para ser retornado como descarga a el cliente*/
    public function descargarFormato($file)
    {
    	return response()->download('../public/files/'.$file.'.xlsx');
    }
}
