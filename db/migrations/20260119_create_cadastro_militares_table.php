<?php

use Phinx\Migration\AbstractMigration;

class CreateCadastroMilitaresTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cadastro_militares');
        $table->addColumn('nome_militar', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('nome_guerra', 'string', ['limit' => 100, 'null' => true])
              ->addColumn('patente', 'string', ['limit' => 50, 'null' => false])
              ->addColumn('lotacao', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('doc_militar_numero', 'string', ['limit' => 60, 'null' => false])
              ->addColumn('doc_militar_arquivo', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('nome_pai', 'string', ['limit' => 150, 'null' => true])
              ->addColumn('nome_mae', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('doc_civil_numero', 'string', ['limit' => 60, 'null' => false])
              ->addColumn('doc_civil_arquivo', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('endereco_pessoal', 'string', ['limit' => 180, 'null' => true])
              ->addColumn('bairro_pessoal', 'string', ['limit' => 80, 'null' => true])
              ->addColumn('cidade_pessoal', 'string', ['limit' => 80, 'null' => true])
              ->addColumn('estado_pessoal', 'string', ['limit' => 2, 'null' => true])
              ->addColumn('cep_pessoal', 'string', ['limit' => 10, 'null' => true])
              ->addColumn('endereco_funcional', 'string', ['limit' => 180, 'null' => true])
              ->addColumn('bairro_funcional', 'string', ['limit' => 80, 'null' => true])
              ->addColumn('cidade_funcional', 'string', ['limit' => 80, 'null' => true])
              ->addColumn('estado_funcional', 'string', ['limit' => 2, 'null' => true])
              ->addColumn('cep_funcional', 'string', ['limit' => 10, 'null' => true])
              ->addColumn('qualificacao', 'string', ['limit' => 60, 'null' => true])
              ->addColumn('indicado_por', 'string', ['limit' => 120, 'null' => true])
              ->addColumn('telefone', 'string', ['limit' => 20, 'null' => false])
              ->addColumn('email', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('conjuge', 'string', ['limit' => 150, 'null' => true])
              ->addColumn('numero_filhos', 'integer', ['signed' => false, 'null' => true])
              ->addColumn('tipo_sanguineo', 'string', ['limit' => 4, 'null' => false])
              ->addColumn('vinculo_mp', 'string', ['limit' => 20, 'null' => false])
              ->addColumn('cursos_json', 'text', ['null' => true, 'comment' => 'Cursos realizados (armazenar como JSON)'])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}
