<?php

/**
 * Adapter for PDO
 */
class ObjectPDOAdapter extends ObjectAdapter
{
    public function __construct(&$db)
    {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        parent::__construct($db);
    }
    
    public function quote($obj, $type = null)
    {
        return $this->db->quote($obj, $type);
    }

    public function getRow($sql)
    {
        try {
            $query = $this->db->prepare($sql);
        } catch (PDOException $exp) {
            throw new DatabaseException(
                $exp->getMessage(), 
                (int) $exp->getCode()
            );
        }

        if($this->db->errorCode() > 0) {
            $info = $this->db->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

    	$res = $query->execute();
        if (!$res) {
            $info = $query->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($sql)
    {
        $result = array();

        try {
            $query = $this->db->prepare($sql);
        } catch (PDOException $exp) {
            throw new DatabaseException(
                $exp->getMessage(), 
                (int) $exp->getCode()
            );
        }
        
        if($this->db->errorCode() > 0) {
            $info = $this->db->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        try {
            $res = $query->execute();
        } catch (PDOException $exp) {
            throw new DatabaseException(
                $exp->getMessage(), 
                (int) $exp->getCode()
            );
        }
        
        if (!$res) {
            $info = $query->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getCol($sql)
    {
        try {
    	   $query = $this->db->prepare($sql);
    	} catch (PDOException $exp) {
    	    throw new DatabaseException(
	            $exp->getMessage(),
	            (int) $exp->getCode()
            );
    	}
    	
        if ($this->db->errorCode() > 0) {
            $info = $this->db->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }
           
        $res = $query->execute();
        if (!$res) {
            $info = $query->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        $result = array();
        while (($cell = $query->fetchColumn()) !== false) {
        	$result[] = $cell;
        }
        
        return $result;
    }

    
    public function getOne($sql)
    {
        try {
            $query = $this->db->prepare($sql);
        } catch (PDOException $exp) {
            throw new DatabaseException(
                $exp->getMessage(),
                (int) $exp->getCode()
            );
        }
        
        if ($this->db->errorCode() > 0) {
            $info = $this->db->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        $res = $query->execute();

    	if (!$res) {
        	$info = $query->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        return $query->fetchColumn();
    }

    public function getAssoc($sql)
    {
    	$result = array();

    	try {
    	   $query = $this->db->prepare($sql);
    	} catch (PDOException $exp) {
    	    throw new DatabaseException(
	            $exp->getMessage(),
	            (int) $exp->getCode()
            );
    	}
    	
    	if($this->db->errorCode() > 0) {
    		$info = $this->db->errorInfo();
    		throw new DatabaseException($info[2], (int) $info[1]);
    	}

    	$res = $query->execute();
    	if (!$res) {
    		$info = $query->errorInfo();
    		throw new DatabaseException($info[2], (int) $info[1]);
    	}
    	
    	$result = array();
    	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    		$val = array_shift($row);
    		if (count($row) == 1) {
    			$row = array_shift($row);
    		}
    		$result[$val] = $row;
    	}

    	return $result;
    }

    public function begin($isolationLevel = false)
    {
        // TODO: Savepoint
        //if ($this->db->inTransaction()) {
        //    $this->commit();
        //}

        $this->db->beginTransaction();
        self::$_isStartTransaction = true;
    }

    public function commit()
    {
        $this->db->commit();
        self::$_isStartTransaction = false;
    }

    public function rollback()
    {
        $this->db->rollBack();
        self::$_isStartTransaction = false;
    }

    public function query($sql)
    {
        try {
            $affected_rows = $this->db->exec($sql);
        } catch (PDOException $exp) {
            throw new DatabaseException(
                $exp->getMessage(), 
                (int) $exp->getCode()
            );
        }

        if ($this->db->errorCode() > 0) {
            $info = $this->db->errorInfo();
            throw new DatabaseException($info[2], (int) $info[1]);
        }

        return $affected_rows;
    }

    public function getInsertID()
    {
        return $this->db->lastInsertId();
    }
	
	public function getDatabaseType()
	{
		$type = $this->db->getAttribute(PDO::ATTR_DRIVER_NAME);
		
		if ($type == "sqlsrv") {
			return DataAccessObject::TYPE_MSSQL;
		}
		
		return $type;
	} // end getDatabaseType
	
}