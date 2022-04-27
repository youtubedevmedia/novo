<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/conexao.php");
class Limite
{	
	private $tabela = "valor_limite";
	private $tabela_log = "valor_log";
	private $tabela_cat = "categoria";

	// TABELA LIMITES
		// SELECT
			public function limiteExibir(int $id_usuario) : float{
				$con = new Conexao();
				
				$sql = "SELECT valor FROM $this->tabela WHERE id_usuario = ". $id_usuario;
				$rs = $con->select($sql);

				if (count($rs) > 0) {
					$valor_limite = $rs[0]->valor;
				} else {
					$valor_limite = 0;
				}
				return $valor_limite;
			}

		// UPDATE
			public function limiteAtualizar(int $id_usuario, float $valor_limite) : bool {
				$con = new Conexao();
				
				$param = array(
					':id_usuario' => $id_usuario,
					':valor' => $valor_limite
				);
				$sql = "UPDATE $this->tabela SET valor = :valor WHERE id_usuario = :id_usuario";
				$rs = $con->update($sql, $param);

				if ($rs > 0) {
					return true;
				} else {

					$sql = "INSERT INTO $this->tabela (id_usuario, valor) VALUES (:id_usuario, :valor)";
					$rs = $con->insert($sql, $param);

					if ($rs > 0) {
						return true;
					} else {
						return false;
					}
				}
			}

	// TABELA LOG
		// SELECT
			public function logDescricaoGastoMes(int $id_log, int $id_usuario) {
				$con = new Conexao();
				
				$sql = "SELECT l.id, l.titulo, l.descricao, l.id_categoria, c.descricao as categoria, l.valor, l.data 
						FROM $this->tabela_log l
						LEFT JOIN $this->tabela_cat c ON c.id = l.id_categoria 
						WHERE l.status = 1 AND l.id = $id_log AND l.id_usuario = $id_usuario";
				#die($sql);
				$rs = $con->select($sql);
						
				if (!empty($rs)) {
					return $rs[0];
				} else {
					return 0;
				}
			}

		// INSERT
			public function logAdicionarGasto(int $id_usuario, string $titulo, int $id_categoria, float $valor, string $data, string $descricao = null) {
				$con = new Conexao();

				$param = array(
					':id_usuario' => $id_usuario,
					':id_categoria' => $id_categoria,
					':titulo' => $titulo,
					':valor' => $valor,
					':data' => $data,
					':descricao' => $descricao
				);
				$sql = "INSERT INTO $this->tabela_log (id_usuario, id_categoria, titulo, valor, data, descricao, status) 
						VALUES (:id_usuario, :id_categoria, :titulo, :valor, :data, :descricao, 1)";
				$rs = $con->insert($sql, $param);

				if ($rs > 0) {
					return true;
				} else {
					return false;
				}
			}

		// DELETE
			public function logRegistroDeletar(int $id_usuario, int $id_registro) : float{
				$con = new Conexao();
				
				$param = array(
					':id_usuario' => $id_usuario,
					':id_registro' => $id_registro
				);
				$sql = "DELETE FROM $this->tabela_log WHERE id_usuario = :id_usuario AND id = :id_registro";
				$rs = $con->delete($sql, $param);

				if ($rs > 0) {
					return true;
				} else {
					return false;
				}
			}

		// AUXILIAR - TOTAL GASTO NO MES
			public function logTotalGastoMes(int $id_usuario, int $mes, int $ano) : float {
				$con = new Conexao();
				
				$sql = "SELECT SUM(valor) AS valor_total FROM $this->tabela_log WHERE id_usuario = $id_usuario AND MONTH(data) = $mes AND YEAR(data) = $ano";
				$rs = $con->select($sql);
						
				if (isset($rs) && $rs[0]->valor_total > 0) {
					return $rs[0]->valor_total;
				} else {
					return 0;
				}
			}

		// AUXILIAR - TOTAL GASTO POR DIA NO MES
			public function logTotalGastoDiaNoMes(int $id_usuario, int $mes, int $ano) {
				$con = new Conexao();
				
				$sql = "SELECT data, DAY(data) AS dia, SUM(valor) AS valor_total FROM $this->tabela_log WHERE id_usuario = $id_usuario AND MONTH(data) = $mes AND YEAR(data) = $ano GROUP BY data";
				$rs = $con->select($sql);
						
				if (isset($rs) && $rs[0]->valor_total > 0) {
					return $rs;
				} else {
					return 0;
				}
			}

	// TABELA LIMITE e LOG
		public function limiteDescricaoGastoMes(int $id_usuario, string $data) {
			$con = new Conexao();
			
			$sql = "SELECT l.id, l.titulo, c.descricao AS categoria, l.valor, l.data 
					FROM $this->tabela_log l
					LEFT JOIN $this->tabela_cat c ON l.id_categoria = c.id
					WHERE l.status = 1 AND l.data = '$data' AND l.id_usuario = $id_usuario";
			$rs = $con->select($sql);
					
			if (count($rs) > 0) {
				return $rs;
			} else {
				return 0;
			}
		}

		public function limiteDescricaoGastoCategoria(int $id_usuario, int $id_categoria, string $mes, string $ano) {
			$con = new Conexao();
			
			$sql = "SELECT id, titulo, valor, data 
					FROM $this->tabela_log 
					WHERE status = 1 AND MONTH(data) = $mes AND YEAR(data) = $ano AND id_categoria = $id_categoria AND id_usuario = $id_usuario
					ORDER BY data DESC";
			$rs = $con->select($sql);
					
			if (count($rs) > 0) {
				return $rs;
			} else {
				return 0;
			}
		}

		public function limiteGastoCategoriaMes(int $id_usuario, int $mes, int $ano) {
			$con = new Conexao();
				
			$sql = "SELECT l.id_categoria, c.descricao,  SUM(valor) AS valor_total 
					FROM $this->tabela_log l, $this->tabela_cat c  
					WHERE l.id_usuario = $id_usuario AND c.id = l.id_categoria AND MONTH(data) = $mes AND YEAR(data) = $ano 
					GROUP BY l.id_categoria, c.descricao
					ORDER BY valor_total DESC";
			$rs = $con->select($sql);
					
			if ($rs > 0) {
				return $rs;
			} else {
				return 0;
			}
		}
}