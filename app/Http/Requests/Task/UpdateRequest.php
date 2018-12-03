<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
use App\Exceptions\AuthorizationException;

class UpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    if ($this->request->has('sprint')) {
      throw new AuthorizationException('У вас недостаточно прав для добавления задач в спринт');
    }
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'string|unique:tasks|max:255',
      'description' => 'string',
      'status' => 'in:0,1,2,3' . $this->user()->isMember() ? '|required' : '',
      'executor' => 'exists:users,id',
      'sprint' => 'exists:sprints,id'
    ];
  }
}
