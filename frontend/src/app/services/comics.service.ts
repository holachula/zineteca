// src/app/services/comic.service.ts

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root' // Hace que el servicio esté disponible en toda la app (Singleton)
})
export class ComicsService {

  // URL base del backend (ej: http://localhost:8000/api)
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {
    // Log para confirmar que el servicio se inicializa correctamente
    console.log("📡 ComicsService inicializado. API:", this.apiUrl);
  }

  // ============================
  // LISTADO PÚBLICO DE CÓMICS
  // ============================

  /**
   * Obtiene todos los cómics
   * Endpoint: GET /comics
   */
  getComics(): Observable<any[]> {
    console.log("📡 ComicsService.getComics() →", `${this.apiUrl}/comics`);
    return this.http.get<any[]>(`${this.apiUrl}/comics`);
  }

  // ============================
  // DETALLE DE UN CÓMIC (LECTOR)
  // ============================

  /**
   * Obtiene un cómic por su slug
   * Endpoint: GET /comics/:slug
   * 
   * Devuelve:
   * - Datos del cómic
   * - Autor
   * - Géneros
   * - Temáticas
   * - Páginas (si el backend las incluye)
   */
  getComic(slug: string) {
    return this.http.get(`${this.apiUrl}/comics/${slug}`);
  }

  // ============================
  // COMICS DEL AUTHOR (PANEL PRIVADO)
  // ============================

  /**
   * Obtiene los cómics del autor autenticado
   * Endpoint: GET /author/comics
   */
  getMyComics(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/author/comics`);
  }

  /**
   * Crea un nuevo cómic desde el panel del autor
   * Endpoint: POST /author/comics
   */
  createMyComic(data: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/author/comics`, data);
  }

  /**
   * Actualiza un cómic del autor
   * Endpoint: PUT /author/comics/:id
   */
  updateMyComic(id: number, data: any): Observable<any> {
    return this.http.put<any>(`${this.apiUrl}/author/comics/${id}`, data);
  }

  /**
   * Elimina un cómic del autor
   * Endpoint: DELETE /author/comics/:id
   */
  deleteMyComic(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/author/comics/${id}`);
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