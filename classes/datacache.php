<?php

class Datacache {

    private $driver = null;

    /**
     * Either returns the driver object or sets it if $driver is a Datacache_Driver object
     * @param  Datacache_Driver $driver A Datacache_Driver object
     * @return Datacache_Driver         A Datacache_Driver object
     * @throws Datacache_InvalidArgument When trying to set a non Datacache_Driver object
     */
    public function driver($driver = false) {
        if ($driver === false)
            return $this->driver;

        if (!($driver instanceof Datacache_Driver))
            throw new Datacache_InvalidArgument('You can only use a Datacache_Driver object.');

        $this->driver = $driver;
    }

    /**
     * Saves data into cache
     * @param  string $id		A unique identifer for a cache item
     * @param  DataCache_Itemexp $data		Item to cache
     * @return bool				Returns true if successful otherwise false
     */
    public function save($id, DataCache_Itemexp $data) {
        $this->driver->save($id, $data);
        return true;
    }

    /**
     * Gets data from cache
     * @param  string  $id      A unique identifer for a cache item
     * @param  mixed $default 	Returns this when cache data doesnt exist
     * @return mixed            Cached data or default
     */
    public function get($id, $default = false) {
        try {
            $data = $this->driver->get($id);
            if (!($data instanceof DataCache_Itemexp))
                throw new DataCache_ItemexpNotFound('The variable returned from the cache driver in not an instance of DataCache_Itemexp');
            return $data();
        } catch (DataCache_ItemexpNotFound $e) {
            return $default;
        }
    }

}

// Exceptions
class Datacache_Exception extends GeneralException {
    
}

class DataCache_ItemexpNotFound extends Datacache_Exception {
    
}

class Datacache_CanNotSave extends Datacache_Exception {
    
}

class Datacache_InvalidArgument extends Datacache_Exception {
    
}