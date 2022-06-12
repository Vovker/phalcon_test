<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class TransactionsMigration_102
 */
class TransactionsMigration_102 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('transactions', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 1,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'details',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 512,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'sender_account_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'details'
                        ]
                    ),
                    new Column(
                        'receiver_account',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'sender_account_id'
                        ]
                    ),
                    new Column(
                        'receiver_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 70,
                            'after' => 'receiver_account'
                        ]
                    ),
                    new Column(
                        'charge_amount',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'receiver_name'
                        ]
                    ),
                    new Column(
                        'total',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'charge_amount'
                        ]
                    ),
                    new Column(
                        'provider_currencies_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'total'
                        ]
                    ),
                    new Column(
                        'status',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'provider_currencies_id'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'after' => 'status'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'after' => 'created_at'
                        ]
                    ),
                    new Column(
                        'auth_token',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 256,
                            'after' => 'updated_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('sender_account_id_index', ['sender_account_id'], ''),
                    new Index('provider_currencies_id_index', ['provider_currencies_id'], '')
                ],
                'references' => [
                    new Reference(
                        'transactions_ibfk_1',
                        [
                            'referencedTable' => 'users',
                            'referencedSchema' => 'phalcon_app',
                            'columns' => ['sender_account_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'transactions_ibfk_3',
                        [
                            'referencedTable' => 'provider_currencies',
                            'referencedSchema' => 'phalcon_app',
                            'columns' => ['provider_currencies_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    )
                ],
                'options' => [
                    'table_type' => 'BASE TABLE',
                    'auto_increment' => '73',
                    'engine' => 'InnoDB',
                    'table_collation' => 'utf8mb4_0900_ai_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
