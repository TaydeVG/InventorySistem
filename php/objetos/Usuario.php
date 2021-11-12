<?php 
/**
 * 
 */
class Usuario
{
	public  $id = 0;
	public  $nombre  = "";
	public  $apellido = "";
	public  $correo = "";
	public  $password = "";
	
	public function getId() 
	{
		return $this->id;
	}
	public function setId($id) 
	{
		$this->id = $id;
	}
	public function getNombre() 
	{
		return $this->nombre;
	}
	public function setNombre($nombre) 
	{
		$this->nombre = $nombre;
	}
	public function getApellido() 
	{
		return $this->apellido;
	}
	public function setApellido($apellido) 
	{
		$this->apellido = $apellido;
	}
	public function getCorreo() 
	{
		return $this->correo;
	}
	public function setCorreo($correo) 
	{
		$this->correo = $correo;
	}
	public function getPassword() 
	{
		return $this->password;
	}
	public function setPassword($password) 
	{
		$this->password = $password;
	}

	public function toString() 
	{
		return "Usuario [id=" . $this->id . ", nombre=" . $this->nombre . ", apellido=" . $this->apellido. ", email=" . $this->email . ", password=" . $this->password . "]";
	}
}
 ?>