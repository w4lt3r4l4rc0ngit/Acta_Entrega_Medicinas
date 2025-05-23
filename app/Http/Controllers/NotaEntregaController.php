<?php

namespace App\Http\Controllers;

use App\Models\Acta_entrega_detalle;
use App\Models\Acta_entregas;
use App\Models\Medicinas;
use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaEntregaController extends Controller
{
    public function create()
    {
        // $num_acta_entrega = NotaEntregaController::generarNumero();
        // $cab_acta_entrega = [
        //     'numero' => $num_acta_entrega,
        //     'estado' => '-1'
        // ];
        // $id_acta_entrega = Acta_entregas::insertGetId($cab_acta_entrega);

        return view('create');
    }

    private static function generarNumero()
    {
        $num = Acta_entregas::orderby('id', 'desc')->max('numero');
        if ($num == '')
            $num = '0000001';
        else {
            $num = $num + 1;
            $num = str_pad($num, 7, 0, STR_PAD_LEFT);
        }
        return $num;
    }

    public function buscar_paciente(Request $request)
    {
        if (strlen($request['q']) >= 3) {
            $pacientes = Pacientes::where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request['q'] . '%')
                    ->orWhere(DB::raw("CONCAT(nombre1, ' ' ,nombre2, ' ', apellido1, ' ', apellido2)"), 'like', '%' . $request['q'] . '%');
            })
                ->where('estado', '1')
                ->select('id', 'nombre1', 'nombre2', 'apellido1', 'apellido2', 'direccion', 'telefono')
                ->limit(10)
                ->get();
            return response()->json($pacientes);
        }
        return response()->json([]);
    }

    public function buscar_producto(Request $request)
    {
        if (strlen($request['q']) >= 3) {
            $producto = Medicinas::where('nombre', 'like', '%' . $request['q'] . '%')
                ->where('estado', '1')
                ->select('id', 'nombre', 'precio')
                ->get();
            return response()->json($producto);
        }
        return response()->json([]);
    }


    public function guardar(Request $request)
    {
        $acta = DB::transaction(function () use ($request) {
            $numero = NotaEntregaController::generarNumero();

            $acta = Acta_entregas::create([
                'numero' => $numero,
                'id_paciente' => $request->buscar_paciente,
                'total' => $request->totalFinal,
                'subtotal_15' => $request->subtotal15,
                'subtotal_0' => $request->subtotal0,
            ]);

            foreach ($request->producto as $index => $producto) {
                Acta_entrega_detalle::create([
                    'id_acta_entrega' => $acta->id,
                    'id_medicina' => $producto,
                    'cantidad' => $request->cantidad[$index],
                    'precio' => $request->precio[$index],
                    'total' => $request->valor_total[$index],
                ]);
            }

            return $acta;
        });
        return redirect()->route('acta.pdf', ['id' => $acta->id]);
    }

    public function verPdf($id)
    {
        $acta = Acta_entregas::findOrFail($id);

        PDF::setOptions([
            'isRemoteEnabled' => true,
        ]);

        $pdf = PDF::loadView('pdf_acta', compact('acta'));
        return $pdf->stream('acta_entrega_' . $acta->numero . '.pdf');
    }
}
