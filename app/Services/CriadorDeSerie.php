<?php

namespace App\Services;
use App\{Serie, Temporada, Episodio};
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{

    public function criarSerie(
        string $nomeSerie,
        int $qtdTemporadas,
        int $epPorTemporada,
        ?string $capa
        ) : Serie {
            DB::beginTransaction();
            $serie = Serie::create([
                'nome' => $nomeSerie,
                'capa' => $capa
            ]);
            $qtdTemporadas = $qtdTemporadas;
            $this->criaTemporadas($qtdTemporadas, $serie, $epPorTemporada);
            DB::commit();

        return $serie;
    }


    /**
     * @param int $qtdTemporadas
     * @param $serie
     * @param int $epPorTemporada
     */
    private function criaTemporadas(int $qtdTemporadas, $serie, int $epPorTemporada): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            $this->criarEpisodios($epPorTemporada, $temporada);
        }
    }

    /**
     * @param int $epPorTemporada
     * @param $temporada
     */
    private function criarEpisodios(int $epPorTemporada, $temporada): void
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}
