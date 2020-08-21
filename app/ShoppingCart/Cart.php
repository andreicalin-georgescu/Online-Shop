<?php

namespace Shop\ShoppingCart;

/**
 * Inspired by Sei Kan's cart class
 *
 * @copyright  2017 Sei Kan <seikan.dev@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @see       https://github.com/seikan/Cart
 */
class Cart
{
	/**
	 * An unique ID for the cart.
	 *
	 * @var string
	 */
	protected $cartId;

	/**
	 * Enable or disable cookie.
	 *
	 * @var bool
	 */
	protected $useCookie = false;

	/**
	 * A collection of cart items.
	 *
	 * @var array
	 */
	private $items = [];

	/**
	 * Initialize cart.
	 *
	 * @param array $options
	 */
	public function __construct($options = [])
	{
		if (!session_id()) {
			session_start();
		}

		if (isset($options['useCookie']) && $options['useCookie']) {
			$this->useCookie = true;
		}

		$this->cartId = md5((isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : 'SimpleCart') . '_cart';

		$this->read();
	}

	public function getItems()
	{
		return $this->items;
	}

	public function isEmpty()
	{
		return empty($this->items);
	}

	public function add($id, $name, $price)
	{
        $this->items[] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
        ];

		$this->write();

		return true;
	}

	public function remove($id)
	{
        $found = false;

        foreach ($this->items as $key => $value) {
            if ($value['id'] == $id) {
                $found = true;
                $itemKey = $key;
                break;
            }
        }

		if (!$found) {
			return false;
		}

        unset($this->items[$itemKey]);

        $this->write();
        
        return true;
	}

    private function read()
	{
		$this->items = ($this->useCookie) ? json_decode((isset($_COOKIE[$this->cartId])) ? $_COOKIE[$this->cartId] : '[]', true) : json_decode((isset($_SESSION[$this->cartId])) ? $_SESSION[$this->cartId] : '[]', true);
	}

    private function write()
	{
		if ($this->useCookie) {
			setcookie($this->cartId, json_encode(array_filter($this->items)), time() + 604800);
		} else {
			$_SESSION[$this->cartId] = json_encode(array_filter($this->items));
		}
	}

    /**
	 * Destroy cart session.
	 */
	public function destroy()
	{
		$this->items = [];

		if ($this->useCookie) {
			setcookie($this->cartId, '', -1);
		} else {
			unset($_SESSION[$this->cartId]);
		}
	}
}

 ?>
