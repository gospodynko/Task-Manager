<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 23:05
 */

namespace App\Engine;


class Model
{
    public $connect;

    /**
     * Model constructor.
     */

    public function __construct()
    {
        $connect = env('DB_DRIVER') . ':dbname=' . env('DB_DATABASE');
        $user = env('DB_USER');
        $password = env('DB_PASSWORD');
        $this->connect = new \PDO($connect, $user, $password);
        $this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->connect->exec("SET CHARACTER SET utf8");
    }

    /**
     * @param null|array $order
     * @return array
     */

    static public function all($order = null)
    {
        $model = new static;
        $sql = "SELECT * FROM " . $model->table;

        if ($order) {
            $sql .= " ORDER BY " . $order['column'] . " " . $order['type'];
        }
        $result = $model->execute($sql);
        return $result;
    }
    static public function update($column = null,$value = null,$key = null,$val = null){
        $model = new static;
        $sql = "UPDATE"." ". $model->table." SET ".$column." = ".$value." WHERE " .$key ." = ".$val;
        $result = $model->execute($sql);
//        $result = $model->fetchAll();
        return  $result = $model->fetchAll();;
    }

    /**
     * @param string $join_table
     * @param string $count_name
     * @param string $column_join
     * @param int $limit
     * @return array
     */
    static public function getPopular(string $join_table, string $count_name, string $column_join, $limit = 5)
    {
        $model = new static;
        $sql = "SELECT " . $model->table . ".*, COUNT(" . $join_table . ".id) as " . $count_name . "  FROM `" . $model->table . "`";
        $sql .= "LEFT JOIN " . $join_table . " ON " . $model->table . ".id=" . $join_table . "." . $column_join;
        $sql .= " GROUP BY " . $model->table . ".id ORDER BY " . $count_name . " DESC LIMIT " . $limit;

        $result = $model->rawSql($sql);
        return $result;
    }

    /**
     * @param array $conditions
     * @return array
     */
    static public function where(array $conditions)
    {
        $model = new static;
        $sql = 'SELECT * FROM ' . $model->table;

        $i = 0;
        $values = [];
        foreach ($conditions as $condition) {
            if ($i === 0) {
                $sql .= ' WHERE ' . $condition[0] . ' ' . $condition[1] . ' ?';
            } else {
                $sql .= ' AND ' . $condition[0] . ' ' . $condition[1] . ' ?';
            }
            array_push($values, htmlspecialchars(trim($condition[2])));
            $i++;

        }
        $sql .= ' ORDER BY id DESC';

        $result = $model->execute($sql, $values);

        return $result;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $conditions
     * @return array
     */
    static public function paginate(int $offset, int $limit = 5, array $conditions = [])
    {
        $model = new static;
        $sql = 'SELECT * FROM ' . $model->table;

        $i = 0;
        $values = [];
        foreach ($conditions as $condition) {
            if ($i === 0) {
                $sql .= ' WHERE ' . $condition[0] . ' ' . $condition[1] . ' ?';
            } else {
                $sql .= ' AND ' . $condition[0] . ' ' . $condition[1] . ' ?';
            }
            array_push($values, htmlspecialchars(trim($condition[2])));
            $i++;

        }
        $sql .= ' ORDER BY id DESC';

        $sql .= ' LIMIT ' . $limit;

        $offset_num = ($offset - 1) * $limit;

        $sql .= ' OFFSET ' . $offset_num;

        $result = $model->execute($sql, $values);

        return $result;
    }

    /**
     * @return int
     */
    static public function count()
    {
        $model = new static;
        $sql = 'SELECT COUNT(*) FROM ' . $model->table;

        $result = $model->getCount($sql);

        return $result;
    }


    /**
     * @param $id
     * @return array|mixed
     */

    static public function find($id)
    {
        $model = new static;
        $result = $model->execute('SELECT * FROM ' . $model->table . ' WHERE ' . $model->key . ' = ?', [$id]);
        if (is_array($result)) {
            $result = current($result);
        }
        return $result;
    }

    /**
     * @param array $data
     * @return string
     */

    static public function add($data)
    {
        try {
            $model = new static;
            $attributes = array_flip($model->attributes);
            $data = array_filter($data, function ($data) use ($attributes) {
                return isset($attributes[$data]);
            }, ARRAY_FILTER_USE_KEY);
            $sql = 'INSERT INTO ' . $model->table . ' (';
            foreach ($data as $column => $value) {
                $sql .= '`' . $column . '`, ';
            }
            $sql = trim($sql, ', ');
            $sql .= ') VALUES (';
            foreach ($data as $column => $value) {
                $sql .= ':' . $column . ', ';
            }
            $sql = trim($sql, ', ');
            $sql .= ')';
            $statement = $model->connect->prepare($sql);
            foreach ($data as $column => $value) {
                $value = htmlspecialchars($value);
                $statement->bindValue(':' . $column, $value);
            }
            try {
                $statement->execute();
                return $model->connect->lastInsertId();
            } catch (PDOExecption $e) {
                $model->connect->rollback();
                return "Error" . $e->getMessage();
            }
        } catch (PDOExecption $e) {
            return "Error" . $e->getMessage();
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */

    public function execute($sql, $params = [])
    {
        $attributes = array_flip($this->attributes);
        $result = [];
        $statement = $this->connect->prepare($sql);
        $statement->execute($params);
        foreach ($statement as $row) {
            $result[] = array_filter($row, function ($data) use ($attributes) {
                return isset($attributes[$data]);
            }, ARRAY_FILTER_USE_KEY);
        }
        return $result;
    }

    /**
     * @param $sql
     * @return array
     */
    public function rawSql($sql)
    {
        $statement = $this->connect->query($sql);

        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * @param $sql
     * @return int
     */
    public function getCount($sql)
    {
        $statement = $this->connect->query($sql)->fetchColumn();
        $count = $statement;
        return (int) $count;
    }
}