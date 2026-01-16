<?php

use Phinx\Migration\AbstractMigration;

class CreateVeiculosTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('registro_veiculos');
        $table->addColumn('nome', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('matricula', 'string', ['limit' => 50, 'null' => true])
              ->addColumn('data_missao', 'date', ['null' => false])
              ->addColumn('modelo', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('quilometragem_inicial', 'integer', ['signed' => false, 'null' => true])
              ->addColumn('quilometragem_final', 'integer', ['signed' => false, 'null' => true])
              ->addColumn('retirada_at', 'time', ['null' => false])
              ->addColumn('devolucao_at', 'time', ['null' => false])
              ->addColumn('observacao', 'text', ['null' => true])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['null' => true])
              ->create();
    }
}
