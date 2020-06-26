<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use Illuminate\Support\Facades\Mail;
use App\{Serie, Temporada, Episodio, User};
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $users = User::all();

        foreach($users as $key => $user){
            $multiplicador = $key + 1;
            $email = new \App\Mail\NovaSerie(
                $request->nome,
                $request->qtd_temporadas,
                $request->ep_por_temporada
            );

            $email->subject = 'Nova série Adicionada';

            $when = now()->addSecond(10 * $multiplicador);
            Mail::to($user)->later($when, $email);
        }

        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} criada com sucesso {$serie->nome}"
            );

        return redirect()->route('listar_series');
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

            return redirect()->route('listar_series');
        }

    public function editaNome($id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);

        $serie->nome = $novoNome;
        $serie->save();
    }
}
