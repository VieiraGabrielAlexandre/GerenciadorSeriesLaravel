<?php

namespace Tests\Feature;

use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Tests\TestCase;
use App\Serie;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemovedorDeSerieTest extends TestCase
{
    private $serie;
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $criadorDeSerie = new CriadorDeSerie();
        $this->serie = $criadorDeSerie->criarSerie(
            'Nome da Série',
            1,
            1
        );
    }

    public function testRemoverUmaSerie()
    {
        $this->assertDatabaseHas('series', ['id' => $this->serie->id]);
        $removedorDeSerie = new RemovedorDeSerie();
        $nomeSerie = $removedorDeSerie->removerSerie($this->serie->id);
        $this->assertIsString($nomeSerie);
        $this->assertEquals('Nome da Série', $this->serie->nome);
        $this->assertDatabaseMissing('series', ['id' => $this->serie->id]);
    }
}
