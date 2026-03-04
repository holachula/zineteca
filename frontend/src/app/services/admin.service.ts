import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminService {
  private API = 'http://127.0.0.1:8000/api/admin';

  constructor(private http: HttpClient) {}

  crearAutor(data: any): Observable<any> {
    return this.http.post(`${this.API}/autores`, data);
  }
}
