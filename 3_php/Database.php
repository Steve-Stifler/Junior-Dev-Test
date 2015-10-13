<?php
/**
 * Description of Database class
 *
 * @author Andre Honsberg
 * @link http://www.andrehonsberg.com/article/php-mysql-class-for-easy-and-simple-mysql-manipulation
 */
class Database {
    private $host;
    private $user;
    private $pass;
    private $name;
    private $link;
    private $error;
    private $errno;
    private $query;

    /*
     * Constructor
     * 
     * @param string $host Name of the host
     * @param string $user Username
     * @param string $pass Password
     * @param string $name Name of the database
     * @param int $conn Allows the connection
     */
    function __construct($host, $user, $pass, $name = "", $conn = 1) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        if (!empty($name)) {
            $this->name = $name;
        }
        if ($conn == 1) {
            $this->connect();
        }
    }

    /*
     * Destructor
     * 
     */
    function __destruct() {
        mysql_close($this->link);
    }

    /*
     * Connects to the database
     */
    public function connect() {
        if ($this->link = mysql_connect($this->host, $this->user, $this->pass)) {
            if (!empty($this->name)) {
                if (!mysql_select_db($this->name)) {
                    $this->exception("Could not connect to the database!");
                }
            }
        } else {
            $this->exception("Could not create database connection!");
        }
    }

    /*
     * Closes connection
     */
    public function close() {
        mysql_close($this->link);
    }
    
    /*
     * Executes SQL query
     * 
     * @param srting $sql SQL query
     * @return mixed
     */
    public function query($sql) {
        if ($this->query = mysql_query($sql)) {
            return $this->query;
        } else {
            $this->exception("Could not query database!");
            return false;
        }
    }

    /*
     * Returns number of rows recieved by a query
     * 
     * @param srting $qid Result of the SQL query
     * @return int
     */
    public function num_rows($qid) {
        if (empty($qid)) {
            $this->exception("Could not get number of rows because no query id was supplied!");
            return false;
        } else {
            return mysql_num_rows($qid);
        }
    }

    /*
     * Returns array with one row of the table selected by a query
     * 
     * @param srting $qid Result of the SQL query
     * @return array
     */
    public function fetch_array($qid) {
        if (empty($qid)) {
            $this->exception("Could not fetch array because no query id was supplied!");
            return false;
        } else {
            $data = mysql_fetch_array($qid);
        }
        return $data;
    }

    /*
     * Returns associative array with one row of the table selected by a query
     * 
     * @param srting $qid Result of the SQL query
     * @return array
     */
    public function fetch_array_assoc($qid) {
        if (empty($qid)) {
            $this->exception("Could not fetch array assoc because no query id was supplied!");
            return false;
        } else {
            $data = mysql_fetch_array($qid, MYSQL_ASSOC);
        }
        return $data;
    }

    /*
     * Returns array with the result of a query
     * 
     * @param srting $sql SQL query
     * @param bool $assoc Should array be associative or not
     * @return array
     */
    public function fetch_all_array($sql, $assoc = true) {
        $data = array();
        if ($qid = $this->query($sql)) {
            if ($assoc) {
                while ($row = $this->fetch_array_assoc($qid)) {
                    $data[] = $row;
                }
            } else {
                while ($row = $this->fetch_array($qid)) {
                    $data[] = $row;
                }
            }
        } else {
            return false;
        }
        return $data;
    }

    /*
     * Returns ID of the last table line
     * 
     * @return int
     */
    public function last_id() {
        if ($id = mysql_insert_id()) {
            return $id;
        } else {
            return false;
        }
    }

    /*
     * Handles exceptions
     */
    private function exception($message) {
        if ($this->link) {
            $this->error = mysql_error($this->link);
            $this->errno = mysql_errno($this->link);
        } else {
            $this->error = mysql_error();
            $this->errno = mysql_errno();
        }
        if (PHP_SAPI !== 'cli') {
            ?>

            <div class="alert-bad">
                <div>
                    Database Error
                </div>
                <div>
                    Message: <?php echo $message; ?>
                </div>
                <?php if (strlen($this->error) > 0): ?>
                    <div>
                        <?php echo $this->error; ?>
                    </div>
                <?php endif; ?>
                <div>
                    Script: <?php echo @$_SERVER['REQUEST_URI']; ?>
                </div>
                <?php if (strlen(@$_SERVER['HTTP_REFERER']) > 0): ?>
                    <div>
                        <?php echo @$_SERVER['HTTP_REFERER']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        } else {
            echo "MYSQL ERROR: " . ((isset($this->error) && !empty($this->error)) ? $this->error : '') . "\n";
        }
    }
}