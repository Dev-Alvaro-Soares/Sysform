<?php

use Phinx\Migration\AbstractMigration;

class CreateRegistroVeiculosTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('registro_veiculos');
        $table->addColumn('nome', 'string', ['limit' => 150, 'null' => true])
              ->addColumn('matricula', 'string', ['limit' => 50, 'null' => true])
              ->addColumn('data_missao', 'date', ['null' => true])
              ->addColumn('modelo', 'string', ['limit' => 150, 'null' => true])
              ->addColumn('quilometragem_inicial', 'integer', ['signed' => false, 'null' => true])
              ->addColumn('quilometragem_final', 'integer', ['signed' => false, 'null' => true])
              ->addColumn('retirada_at', 'time', ['null' => true])
              ->addColumn('devolucao_at', 'time', ['null' => true])
              ->addColumn('observacao', 'text', ['null' => true])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['null' => true])
              ->create();
    }
}
