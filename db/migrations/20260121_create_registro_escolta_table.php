<?php

use Phinx\Migration\AbstractMigration;

class CreateRegistroEscoltaTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('registro_escolta');
        $table->addColumn('nome_protegido', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('atividade_missao', 'string', ['limit' => 100, 'null' => false])
              ->addColumn('localidades', 'text', ['null' => false])
              ->addColumn('data_inicio_missao', 'string', ['limit' => 20, 'null' => false])
              ->addColumn('data_final_missao', 'string', ['limit' => 20, 'null' => false])
              ->addColumn('horario_chegada', 'string', ['limit' => 10, 'null' => false])
              ->addColumn('horario_saida', 'string', ['limit' => 10, 'null' => false])
              ->addColumn('descricao_atividades', 'text', ['null' => false])
              ->addColumn('observacoes', 'text', ['null' => true])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}
