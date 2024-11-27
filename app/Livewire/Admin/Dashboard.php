<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Cliente;
use App\Models\Medio;
use App\Models\Producto;
use App\Models\Tiempo;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{

    public $yearSelected, $quarterSelected, $monthSelected, $daySelected, $generoSelected;
    public $dataMes = [], $reviewSelected, $categorySelected, $yearMonths;
    public $years, $quarters, $meses, $days, $generos;

    public function render()
    {
        $users = Cliente::all();
        $categories = Medio::all();
        $products = Producto::all();
        $ventas = Venta::all();

        $this->generateYears();
        $this->generateQuarters();
        $this->meses();
        $this->generateDays();
        $this->generateGeneros();

        $ventasClientes = Venta::select(
            'dim_cliente.nombre_completo as cliente',
            DB::raw('COUNT(fact_ventas.id_venta) as cantidad_ventas'),
            DB::raw('SUM(fact_ventas.total) as total_ventas'), // Asume que hay una columna "total" en fact_ventas
            'dim_producto.genero as genero',
            'dim_medio.nombre as medio'
        )
            ->join('dim_cliente', 'fact_ventas.id_cliente', '=', 'dim_cliente.id_cliente')
            ->join('dim_producto', 'fact_ventas.id_producto', '=', 'dim_producto.id_producto')
            ->join('dim_medio', 'fact_ventas.id_medio', '=', 'dim_medio.id_medio')
            ->join('dim_tiempo', 'fact_ventas.id_tiempo', '=', 'dim_tiempo.id_tiempo')
            ->when($this->yearSelected, function ($query) {
                $query->where('dim_tiempo.anio', $this->yearSelected);
            })
            ->when($this->quarterSelected, function ($query) {
                $query->whereRaw('QUARTER(dim_tiempo.fecha) = ?', [$this->quarterSelected]);
            })
            ->when($this->monthSelected, function ($query) {
                $query->where('dim_tiempo.mes', $this->monthSelected);
            })
            ->when($this->daySelected, function ($query) {
                $query->where('dim_tiempo.dia', $this->daySelected);
            })
            ->when($this->generoSelected, function ($query) {
                $query->where('dim_producto.genero', $this->generoSelected);
            })
            ->groupBy('dim_cliente.nombre_completo', 'dim_producto.genero', 'dim_medio.nombre')
            ->get()
            ->toArray();

        $vgeneros = Venta::select(
            'dim_producto.genero as genero',
            DB::raw('COUNT(*) as cantidad_ventas'),
            DB::raw('SUM(total) as total_ventas')
        )
            ->join('dim_producto', 'fact_ventas.id_producto', '=', 'dim_producto.id_producto')
            ->when($this->yearSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('anio', $this->yearSelected);
                });
            })
            ->when($this->quarterSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->whereRaw('QUARTER(fecha) = ?', [$this->quarterSelected]);
                });
            })
            ->when($this->monthSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('mes', $this->monthSelected);
                });
            })
            ->when($this->daySelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('dia', $this->daySelected);
                });
            })
            ->when($this->generoSelected, function ($query) {
                $query->whereHas('dim_producto', function ($q) {
                    $q->where('genero', $this->generoSelected);
                });
            })
            ->groupBy('dim_producto.genero')
            ->get()
            ->toArray();


        $bar1 = Venta::select(
            'dim_vendedor.nombre as vendedor',
            DB::raw('COUNT(*) as cantidad_ventas'),
            DB::raw('SUM(total) as total_ventas')
        )
            ->join('dim_vendedor', 'fact_ventas.id_vendedor', '=', 'dim_vendedor.id_vendedor')
            ->when($this->yearSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('anio', $this->yearSelected);
                });
            })
            ->when($this->quarterSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->whereRaw('QUARTER(fecha) = ?', [$this->quarterSelected]);
                });
            })
            ->when($this->monthSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('mes', $this->monthSelected);
                });
            })
            ->when($this->daySelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('dia', $this->daySelected);
                });
            })
            ->when($this->generoSelected, function ($query) {
                $query->whereHas('dim_producto', function ($q) {
                    $q->where('genero', $this->generoSelected);
                });
            })
            ->groupBy('dim_vendedor.nombre')
            ->get()
            ->toArray();


        $labels1 = array_column($bar1, 'vendedor');
        $data1 = array_column($bar1, 'cantidad_ventas');

        $totalVentas = array_sum(array_column($bar1, 'total_ventas'));

        $pie1 = Venta::select('dim_medio.nombre as medio', DB::raw('COUNT(*) as total'), DB::raw('SUM(total) as total_ventas'))
            ->join('dim_medio', 'fact_ventas.id_medio', '=', 'dim_medio.id_medio')
            ->when($this->yearSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('anio', $this->yearSelected);
                });
            })
            ->when($this->quarterSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->whereRaw('QUARTER(fecha) = ?', [$this->quarterSelected]);
                });
            })
            ->when($this->monthSelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('mes', $this->monthSelected);
                });
            })
            ->when($this->daySelected, function ($query) {
                $query->whereHas('dim_tiempo', function ($q) {
                    $q->where('dia', $this->daySelected);
                });
            })
            ->when($this->generoSelected, function ($query) {
                $query->whereHas('dim_producto', function ($q) {
                    $q->where('genero', $this->generoSelected);
                });
            })
            ->groupBy('dim_medio.nombre')
            ->get()
            ->toArray();

        $labels2 = array_column($pie1, 'medio');
        $data2 = array_column($pie1, 'total');

        $totalVentas2 = array_sum(array_column($pie1, 'total_ventas'));

        if ($this->yearSelected || $this->monthSelected || $this->quarterSelected || $this->daySelected || $this->generoSelected) {
            $this->dispatch('post-created', [
                'dataAll' => [
                    $data1,
                ],
                'dataToday' => [
                    $data2,
                ]
            ]);
        } else {
            $this->dispatch('post-created', [
                'dataAll' => [
                    $data1,
                ],
                'dataToday' => [
                    $data2,
                ]
            ]);
        }

        return view('livewire.admin.dashboard', compact('users', 'categories', 'products', 'ventas', 'labels1', 'data1', 'labels2', 'data2', 'totalVentas', 'bar1', 'pie1', 'vgeneros', 'ventasClientes'));
    }

    public function generateYears()
    {
        $years = Tiempo::selectRaw('DISTINCT anio')
            ->orderBy('anio', 'asc')
            ->pluck('anio')
            ->toArray();

        $this->years = $years;
    }

    public function generateQuarters()
    {
        $this->quarters = [
            ['quarter' => 1, 'label' => 'Primer Trimestre'],
            ['quarter' => 2, 'label' => 'Segundo Trimestre'],
            ['quarter' => 3, 'label' => 'Tercer Trimestre'],
            ['quarter' => 4, 'label' => 'Cuarto Trimestre'],
        ];
    }

    public function meses()
    {
        $this->meses = [
            ['id' => 1,  'name' => 'Enero'],
            ['id' => 2,  'name' => 'Febrero'],
            ['id' => 3,  'name' => 'Marzo'],
            ['id' => 4,  'name' => 'Abril'],
            ['id' => 5,  'name' => 'Mayo'],
            ['id' => 6,  'name' => 'Junio'],
            ['id' => 7,  'name' => 'Julio'],
            ['id' => 8,  'name' => 'Agosto'],
            ['id' => 9,  'name' => 'Septiembre'],
            ['id' => 10, 'name' => 'Octubre'],
            ['id' => 11, 'name' => 'Noviembre'],
            ['id' => 12, 'name' => 'Diciembre'],
        ];
    }

    public function generateDays()
    {
        $this->days = collect(range(1, 31))->map(function ($day) {
            return [
                'day' => $day,
                'label' => 'Día ' . $day,
            ];
        })->toArray();
    }

    public function generateGeneros()
    {
        $this->generos = Producto::select('genero')
            ->distinct()
            ->orderBy('genero', 'asc')
            ->pluck('genero')
            ->toArray();
    }
}
