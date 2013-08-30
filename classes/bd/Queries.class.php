<?php

abstract class Queries {
	const SELECT = "SELECT {campos} FROM {tabela} {where} {order} {limit};";
	const SELECT_JOIN = "SELECT {campos} FROM {tabela} {join} {where} {order} {limit};";
	const SELECT_DISTINCT = "SELECT DISTINCT {campos} FROM {tabela} {where} {order} {limit};";
	const INSERT= "INSERT INTO {tabela} ({campos}) VALUES ({valores});";
	const INSERT_DUPLICATE= "INSERT INTO {tabela} ({campos}) VALUES ({valores}) ON DUPLICATE KEY UPDATE {duplicate};";
	const UPDATE= "UPDATE {tabela} SET {campos} = '{valores}';";
	const UPDATE_WHERE= "UPDATE {tabela} SET {campos} = '{valores}' {where};";
	const DELETE = "DELETE FROM {tabela} {where};";
	const TOKEN_INSERT_VALORES = "{valores}";
	const TOKEN_INSERT_DUPLICATE = "{duplicate}";
	const TOKEN_UPDATE_VALOR = self::TOKEN_INSERT_VALORES;//alias
	const TOKEN_CAMPOS = "{campos}";
	const TOKEN_UPDATE_CAMPOS = self::TOKEN_CAMPOS;//alias
	const TOKEN_TABELA = "{tabela}";
	const TOKEN_WHERE = "{where}";
	const TOKEN_JOIN = "{join}";
	const TOKEN_ORDER = "{order}";
	const TOKEN_LIMIT = "{limit}";
}