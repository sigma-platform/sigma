<?php namespace App\Models;

use Rhumsaa\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Token extends Model {

	/**
	 * Name of the table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'token';

	/**
	 * Name of the primary key used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'token';

	/**
	 * List of assignable fields
	 *
	 * @var array
	 */
	protected $fillable = ['user_id'];

	/**
	 * List of fields that are excluded from JSON returns.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at', 'updated_at'];

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::creating(function (Token $model) {
			$model->token = (string)$model->generateNewToken();
		});
	}

	/**
	 * Get a new version 4 (random) UUID.
	 *
	 * @return Uuid
	 */
	public function generateNewToken()
	{
		return Uuid::uuid4();
	}

	/**
	 * Get a token by its value.
	 *
	 * @param string $token
	 *
	 * @return Token
	 */
	public static function getToken($token)
	{
		return Token::find($token);
	}
}