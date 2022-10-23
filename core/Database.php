<?php

namespace app\core;

abstract class Database
{
	private static $userName = 'root';
	private static $userPassword = 'root';
	public static $connection;

	public static function getConnection(): \PDO
	{
		try {
			$dsn = 'mysql:host=db;port=3306;dbname=users;charset=utf8';
			static::$connection = new \PDO($dsn, self::$userName, self::$userPassword);
            static::$connection->exec('CREATE TABLE IF NOT EXISTS users (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `email` varchar(50) NOT NULL,
                `gender` varchar(20) NOT NULL,
                `status` varchar(20) NOT NULL,
                PRIMARY KEY (`id`)
            )');
		} catch (\PDOException $exception) {
			echo $exception->getMessage();
		}
		return static::$connection;
	}
}
