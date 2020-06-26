<?php

namespace App\Services;
use App\{Events\SerieApagada, Serie, Temporada, Episodio};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RemovedorDeSerie
{
    public function removerSerie(int $serieId) : string
    {
        $nomeSerie = '';
        DB::transaction(function () use ($serieId, &$nomeSerie){
            $serie = Serie::find($serieId);
            $serieObj = (object) $serie->toArray();

            $nomeSerie = $serie->nome;

            $this->removerTemporadas($serie);
            $serie->delete();

            $evento = new SerieApagada($serie);
            event($evento);

        });
        return $nomeSerie;
    }

    /**
     * @param $serie
     */
    private function removerTemporadas($serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    /**
     * @param Temporada $temporada
     * @throws \Exception
     */
    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios()->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }

}
