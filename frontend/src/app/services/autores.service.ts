// services/autores.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AutoresService {

  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {
    console.log("📡 AutoresService inicializado. API:", this.apiUrl);
  }

  getAutores() {
    console.log("📡 AutoresService.getAutores() ejecutado →", `${this.apiUrl}/autores`);
    return this.http.get<any[]>(`${this.apiUrl}/autores`);
  }
  getAutor(slug: string): Observable<any> {
  return this.http.get<any>(`${this.apiUrl}/autores/${slug}`);
}
agregarAutor(autor: any) {
  console.log("📡 AutoresService.agregarAutor()", autor);
  return this.http.post(`${this.apiUrl}/autores`, autor);
}
}











// import { Injectable } from '@angular/core';
// import { HttpClient } from '@angular/common/http';
// import { environment } from '../../environments/environment';
// import { Observable } from 'rxjs';

// @Injectable({
//   providedIn: 'root'
// })
// export class AutoresService {

//   private apiUrl = environment.apiUrl;

//   constructor(private http: HttpClient) {}

//  getAutores(): Observable<any[]> {
//   return this.http.get<any[]>(`${this.apiUrl}/autores`);
// }

//   getAutor(id: number): Observable<any> {
//     return this.http.get(`${this.apiUrl}/autores/${id}`);
//   }
// }
