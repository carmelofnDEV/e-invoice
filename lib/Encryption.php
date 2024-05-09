<?php

namespace Intratum\Facturas;

/*
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

$enc = new \Intratum\Facturas\Encryption();
$enc->setKey('private');
$codi = $enc->encode(json_encode([30,20240504]));
echo $enc->decode($codi);
*/

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

class Encryption{
	private $key;
	
	public function setKey(string $typeKey){
		$keyAscii = null;
		
		switch($typeKey){
			default:
				global $config;
				$keyAscii = file_get_contents('./.secret/'.$typeKey.'.key');
			break;
		}
		
		$key = Key::loadFromAsciiSafeString($keyAscii);
		$this->key = $key;
	}
	
	public static function generateKey(){
		$key = Key::createNewRandomKey();
		return $key->saveToAsciiSafeString();
	}

    public function encode($value){
        $ciphertext = Crypto::encrypt($value, $this->key);
		return $ciphertext;
    }

    public function decode($value){
		try{
			$value_decode = Crypto::decrypt($value, $this->key);
			
			return $value_decode;
		}catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex){
			// An attack! Either the wrong key was loaded, or the ciphertext has
			// changed since it was created -- either corrupted in the database or
			// intentionally modified by Eve trying to carry out an attack.

			// ... handle this case in a way that's suitable to your application ...
		}
    }
	
	public static function encryptCookie($key, $encryption_iv, $value){
	   $ciphering = "aes-128-cbc";
	   $iv_length = \openssl_cipher_iv_length($ciphering);
	   $options = 0;
	   
	   $encryption = \openssl_encrypt($value, $ciphering, 
            $key, $options, $encryption_iv);
			
		return $encryption;
	}

	public static function decryptCookie($key, $encryption_iv, $value){
	   $ciphering = "aes-128-cbc";
	   $iv_length = \openssl_cipher_iv_length($ciphering);
	   $options = 0;
	   
	   $encryption = \openssl_decrypt($value, $ciphering, 
            $key, $options, $encryption_iv);
			
		return $encryption;
	}
	
	public static function encryptAes($key, $encryption_iv, $value){
	   $ciphering = "aes-192-ofb";
	   $iv_length = \openssl_cipher_iv_length($ciphering);
	   $options = 1;
	   
	   $encryption = \openssl_encrypt($value, $ciphering, 
            $key, true, $encryption_iv);
$base128chars = "\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0A\x0B\x0C\x0D\x0E\x0F"
              . "\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1A\x1B\x1C\x1D\x1E\x1F"
              . "\x20\x21\x22\x23\x24\x25\x26\x27\x28\x29\x2A\x2B\x2C\x2D\x2E\x2F"
              . "\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x3A\x3B\x3C\x3D\x3E\x3F"
              . "\x40\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4A\x4B\x4C\x4D\x4E\x4F"
              . "\x50\x51\x52\x53\x54\x55\x56\x57\x58\x59\x5A\x5B\x5C\x5D\x5E\x5F"
              . "\x60\x61\x62\x63\x64\x65\x66\x67\x68\x69\x6A\x6B\x6C\x6D\x6E\x6F"
              . "\x70\x71\x72\x73\x74\x75\x76\x77\x78\x69\x7A\x7B\x7C\x7D\x7E\x7F";
			  

		$encoded = str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($encryption));
		
		// RFC 4648 base64url with native functions...
		//$encoded = str_replace(array('+', '/', '='), array('', '', ''), base64_encode($encryption));
		// ZW5jb2RlIHRoaXMgv8K_
		
		return $encoded;
	}

	public static function decryptAes($key, $encryption_iv, $value){
	   $ciphering = "aes-192-ofb";
	   $iv_length = \openssl_cipher_iv_length($ciphering);
	   $options = 0;
	   
	   $value = base64_decode($value);
	   //echo $value;
	   
	   $encryption = \openssl_decrypt($value, $ciphering, 
            $key, true, $encryption_iv);
		
		
		return $encryption;
	}
	
	private static function crockford32_encode($data) {
		$chars = '0123456789abcdefghjkmnpqrstvwxyz';
		$mask = 0b11111;

		$dataSize = strlen($data);
		$res = '';
		$remainder = 0;
		$remainderSize = 0;

		for($i = 0; $i < $dataSize; $i++) {
			$b = ord($data[$i]);
			$remainder = ($remainder << 8) | $b;
			$remainderSize += 8;
			while($remainderSize > 4) {
				$remainderSize -= 5;
				$c = $remainder & ($mask << $remainderSize);
				$c >>= $remainderSize;
				$res .= $chars[$c];
			}
		}
		if($remainderSize > 0) {
			$remainder <<= (5 - $remainderSize);
			$c = $remainder & $mask;
			$res .= $chars[$c];
		}

		return $res;
	}

	private static function crockford32_decode($data) {
		$map = [
			'0' => 0,
			'O' => 0,
			'o' => 0,
			'1' => 1,
			'I' => 1,
			'i' => 1,
			'L' => 1,
			'l' => 1,
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
			'6' => 6,
			'7' => 7,
			'8' => 8,
			'9' => 9,
			'A' => 10,
			'a' => 10,
			'B' => 11,
			'b' => 11,
			'C' => 12,
			'c' => 12,
			'D' => 13,
			'd' => 13,
			'E' => 14,
			'e' => 14,
			'F' => 15,
			'f' => 15,
			'G' => 16,
			'g' => 16,
			'H' => 17,
			'h' => 17,
			'J' => 18,
			'j' => 18,
			'K' => 19,
			'k' => 19,
			'M' => 20,
			'm' => 20,
			'N' => 21,
			'n' => 21,
			'P' => 22,
			'p' => 22,
			'Q' => 23,
			'q' => 23,
			'R' => 24,
			'r' => 24,
			'S' => 25,
			's' => 25,
			'T' => 26,
			't' => 26,
			'V' => 27,
			'v' => 27,
			'W' => 28,
			'w' => 28,
			'X' => 29,
			'x' => 29,
			'Y' => 30,
			'y' => 30,
			'Z' => 31,
			'z' => 31,
		];

		$data = strtolower($data);
		$dataSize = strlen($data);
		$buf = 0;
		$bufSize = 0;
		$res = '';

		for($i = 0; $i < $dataSize; $i++) {
			$c = $data[$i];
			if(!isset($map[$c])) {
				throw new \Exception("Unsupported character $c (0x".bin2hex($c).") at position $i");
			}
			$b = $map[$c];
			$buf = ($buf << 5) | $b;
			$bufSize += 5;
			if($bufSize > 7) {
				$bufSize -= 8;
				$b = ($buf & (0xff << $bufSize)) >> $bufSize;
				$res .= chr($b);
			}
		}

		return $res;
	}
}
