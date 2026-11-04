/*
|--------------------------------------------------------------------------
| File: src/app/services/home.service.ts
|--------------------------------------------------------------------------
| Servicio encargado de:
| - Obtener comics del Home
| - Obtener autores del Home
| - Obtener datos dinámicos para filtros (géneros, temáticas,
|   estados y años)
|
| Este servicio centraliza todas las llamadas HTTP
| relacionadas con el Home.
|--------------------------------------------------------------------------
*/

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HomeService {

  /*
  |--------------------------------------------------------------------------
  | URL Base de la API
  |--------------------------------------------------------------------------
  | Se construye desde environment para permitir:
  | - Desarrollo (localhost)
  | - Producción (dominio real)
  |--------------------------------------------------------------------------
  */
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  /*
  |--------------------------------------------------------------------------
  | Obtener todos los comics del Home
  |--------------------------------------------------------------------------
  | Devuelve:
  | - Autor
  | - Géneros
  | - Temáticas
  |--------------------------------------------------------------------------
  */
  getComics(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/home/comics`);
  }

  /*
  |--------------------------------------------------------------------------
  | Obtener todos los autores
  |--------------------------------------------------------------------------
  | Incluye sus comics con relaciones
  |--------------------------------------------------------------------------
  */
  getAutores(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/home/autores`);
  }

  /*
  |--------------------------------------------------------------------------
  | Obtener lista de géneros
  |--------------------------------------------------------------------------
  | Se usa para llenar el <select> de Género
  |--------------------------------------------------------------------------
  */
  getGeneros(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/home/generos`);
  }

  /*
  |--------------------------------------------------------------------------
  | Obtener lista de temáticas
  |--------------------------------------------------------------------------
  | Se usa para llenar el <select> de Temática
  |--------------------------------------------------------------------------
  */
  getTematicas(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/home/tematicas`);
  }

  /*
  |--------------------------------------------------------------------------
  | Obtener estados únicos de autores
  |--------------------------------------------------------------------------
  | Se usa para llenar el <select> de Estado
  |--------------------------------------------------------------------------
  */
  getEstados(): Observable<string[]> {
    return this.http.get<string[]>(`${this.apiUrl}/home/estados`);
  }

  /*
  |--------------------------------------------------------------------------
  | Obtener años únicos de publicación
  |--------------------------------------------------------------------------
  | Se usa para llenar el <select> de Año
  |--------------------------------------------------------------------------
  */
  getAnios(): Observable<number[]> {
    return this.http.get<number[]>(`${this.apiUrl}/home/anios`);
  }
}