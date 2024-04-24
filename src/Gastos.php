<?php
require_once('Database.php');
if (isset($_POST['accion'])) {
    $Gasto = new Gastos();
    switch ($_POST['accion']) {

        case 'obtener_todos':

            echo json_encode($Gasto->obtener_todos());
            break;
        case 'obtener':
            if (isset($_POST['filtro']) && isset($_POST['valor'])) {
                echo json_encode($Gasto->obtener($_POST['filtro'], $_POST['valor']));
            } else {
                echo json_encode($Gasto->obtener());
            }
            break;
        case 'obtener_gasto':
            if(isset($_POST['id'])){
                echo json_encode($Gasto->obtener($_POST['id']));
            } else{
                echo json_encode('Error: se debe especificar un id');
            }
        case 'eliminar':
            if (isset($_POST['id'])) {
                echo json_encode($Gasto->eliminar_gasto($_POST['id']));
            } else {
                echo json_encode('Error: se debe especificar un id');
            }
            break;
        case 'actualizar':
            if (isset($_POST['datos'])) {
                if (isset($_POST['filtro']) && isset($_POST['valor'])) {
                    echo json_encode($Gasto->actualizar($_POST['datos'], $_POST['filtro'], $_POST['valor']));
                } else {
                    echo json_encode($Gasto->actualizar($_POST['datos']));
                }
            } else {
                echo json_encode('Error: no se han introducido datos');
            }
            break;
        case 'aniadir':
            if (isset($_POST['datos'])) {
                echo json_encode($Gasto->aniadir($_POST['datos']));
            } else {
                echo json_encode('Error: no se han introducido datos');
            }
            break;
        case 'total':
            echo json_encode($Gasto->total());
            break;
        case 'suma';
            echo json_encode($Gasto->obtener_suma_gastos());
            break;
        default:
            echo json_encode('La acción no existe');
    }
}
class Gastos
{
    private $tabla = 'gastos';
    private Database $db;

    public function __construct()
    {
        $this->db = new Database('contab', 'localhost', 'root', '');
    }

      /**
     * Obtiene los datos de la tabla gastos según el filtro que se aplique.
     * 
     * @param string $filter
     * [opcional] El campo a partir del cuál se quieren filtrar los datos
     * @param mixed $valor
     * [opcional] El valor que debe tener el campo de filtro
     * @return array
     * Devuelve un array con los datos obtenidos o con un mensaje de error.
     */

     public function obtener(string $filter = '', mixed $valor = ''): array
     {
         return $this->db->obtener_datos('gastos', [], $filter, $valor);
     }

    /**
     * Obtiene todos los datos de la tabla gastos
     * 
     * @return array
     * Devuelve un array con los datos de la tabla gastos
     */
    public function obtener_todos(): array
    {
        return $this->db->obtener_datos($this->tabla);
    }

    /**
     * Elimina un registro de la tabla gastos según el ID que se introduzca
     * @param int $ID
     * EL ID del registro que se quiere eliminar
     * @return null|bool
     * Devolverá true si el registro se ha eliminado, false si no o null si ha habido algún error
     * 
     */
    public function eliminar_gasto(int $ID): ?bool
    {
        return $this->db->eliminar($ID, $this->tabla);
    }

    /**
     * Obtiene un registro de la tabla gastos según el ID que se introduzca
     * @param int $ID 
     * El ID del registro que se desea obtener
     * @return array
     * Devuelve un array con los datos del registro obtenido
     */

    public function obtener_gasto(int $ID): array
    {
        return $this->db->obtener_datos($this->tabla, [], 'id', $ID);
    }

    /**
     * Obtiene la suma de todos los gastos
     * @return null|float
     * Devuelve un float con la suma de todos los gastos, o null en caso de error
     */

    public function obtener_suma_gastos(): ?float
    {
        return $this->db->suma($this->tabla, 'importe');
    }

    /**
     * Modifica los campos deseados
     * 
     * @param array $datos
     * Los campos que se quiere modificar junto con los valores que se les desean añadir, debe seguir la siguiente sintaxis
     * [Nombre del campo => valor nuevo]
     * @param string $filtro
     * [opcional] el parámetro que indica que registro quieres modificar, en el caso de estar vacío, se modificarán todos los registros
     * @param mixed $valor
     * [opcional] el valor que el campo del registro que se quiere modificar debe tener según el parámetro de búsqueda.
     * @return null|bool
     * Devuelve true si se ha modificado algún parámetro, false si ningún registro se ha visto afectado y NULL si ha habido un error.
     */
    public function actualizar(array $datos, string $filtro = '', mixed $valor = ''): ?bool
    {
        return $this->db->modificar($this->tabla, $datos, $filtro, $valor);
    }

    /**
     * Inserta un nuevo registro en la tabla gastos indicada con los datos indicados
     * 
     * @param array $datos
     * Los valores que se le desean dar a cada uno de las columnas de la tabla, en 
     * el orden correspondiente
     * @return bool
     * Devuelve true en el caso de que se inserten los datos o false en caso de error
     */
    public function aniadir(array $datos): bool
    {
        return $this->db->aniadir($this->tabla, $datos);
    }

    /**
     * Obtiene el total de registros en la tabla gastos
     * @return null|int
     * Devuelve el total de registros en el caso de funcionar o null en el caso de haber
     * un error
     */
    public function total(): int
    {
        return $this->db->obtener_total($this->tabla);
    }
}
