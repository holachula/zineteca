// services/authors.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Author } from '../models/author.model';
/*
SERVICIO DE AUTORES

Se encarga de comunicarse con la API
para obtener y actualizar el perfil del autor.
*/

@Injectable({
  providedIn: 'root'
})
export class AuthorsService {

  private api = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  /*
  Obtener perfil del autor logueado
  */

 getMyProfile() {
  return this.http.get<Author>(`${this.api}/author/profile`);
}

/*
Actualizar perfil del autor

IMPORTANTE:
PHP no procesa archivos en requests PUT con multipart/form-data.
Por eso usamos POST y enviamos el campo especial "_method=PUT"
para que Laravel interprete la petición como PUT.
*/
updateMyProfile(data: FormData) {

  // Indicamos a Laravel que esta petición POST debe tratarse como PUT
  data.append('_method', 'PUT');

  return this.http.post<Author>(`${this.api}/author/profile`, data);
}

}