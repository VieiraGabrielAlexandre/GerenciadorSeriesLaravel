<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\{Serie, Temporada, Episodio};
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request) {

        $series = Serie::query()->orderBy('nome')->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }
    
    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {

        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada,
        );

        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} criada com sucesso {$serie->nome}"
            );

        return redirect()->route('lista_series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removerdorDeSerie)
    {
        
        $nomeSerie = $removerdorDeSerie->removerSerie(
            $request->id
        );
    
        $request->session()
            ->flash(
                'mensagem',
                "Série removida com sucesso"
            );

            return redirect()->route('lista_series');
        }
}