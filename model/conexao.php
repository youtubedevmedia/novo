<?php 
class Conexao
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $con;

    function __construct() { 
        try {
            $this->host = "162.241.2.26";
            $this->db = "fernan40_controle_diario";
            $this->user = "fernan40_crtldia";
            $this->pass = "f4#4f@4fd!4s";

            $this->con = new PDO("mysql:host=" .$this->host. ";dbname=" .$this->db."", $this->user, $this->pass);

        } catch (PDOException $e) {
            print "Erro de conexao: " . $e->getMessage() . "<br/>";
            exit;
        }
    }

    public function select($sql){
        try {
            #die($sql);
            $rs = $this->con->query($sql)->fetchAll(PDO::FETCH_CLASS);  
            return  $rs;
        } catch (Exception $e) {
            print "Erro de conexao select!: " . $e->getMessage() . "<br/>";
            exit;
        }
    }

    public function insert($sql, $param){
        try {
            $rs = $this->con->prepare($sql);
            $rs->execute($param);   
            return  $rs->rowCount();
        } catch (Exception $e) {
            print "Erro de conexao insert!: " . $e->getMessage() . "<br/>";
            exit;
        }
    }

    public function update($sql, $param){
        try {
            #die($sql);
            $rs = $this->con->prepare($sql);
            $rs->execute($param);
            return  $rs->rowCount();
        } catch (Exception $e) {
            print "Erro de conexao update!: " . $e->getMessage() . "<br/>";
            exit;
        }
    }

    public function delete($sql, $param){
        try {
            #die($sql);
            $rs = $this->con->prepare($sql);
            $rs->execute($param);
            return  $rs->rowCount();
        } catch (Exception $e) {
            print "Erro de conexao delete!: " . $e->getMessage() . "<br/>";
            exit;
        }
    }
}