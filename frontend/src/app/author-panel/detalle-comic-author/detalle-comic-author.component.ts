// src/app/author-panel/detalle-comic-author/detalle-comic-author.component.ts

import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { ComicsService } from '../../services/comics.service';

@Component({
  selector: 'detalle-comic-autor',

  // Standalone component (Angular moderno)
  standalone: true,

  // Módulos necesarios para usar directivas como *ngIf, *ngFor y routerLink
  imports: [CommonModule, RouterModule],

  // Archivo HTML asociado
  templateUrl: './detalle-comic-author.component.html',

  // Archivo SCSS asociado
  styleUrls: ['./detalle-comic-author.component.scss']
})
export class DetalleComicAutorComponent implements OnInit {

  // Almacena la información completa del cómic
  // Incluye autor, géneros, temáticas y páginas (si vienen del backend)
  comic: any = null;

  // Controla el estado de carga para mostrar spinner o mensaje
  cargando = true;

  constructor(
    // Permite leer parámetros de la URL (como el slug)
    private route: ActivatedRoute,

    // Servicio que se encarga de hacer peticiones HTTP al backend
    private comicService: ComicsService
  ) {}

  ngOnInit(): void {

    // Obtiene el parámetro 'slug' desde la URL
    // Ejemplo: /comics/mi-comic-epico
    const slug = this.route.snapshot.paramMap.get('slug');

    // Si no existe slug, mostramos error en consola y detenemos carga
    if (!slug) {
      console.error("❌ No se recibió slug en la URL");
      this.cargando = false;
      return;
    }

    console.log("🟦 Slug recibido en detalle:", slug);

    // Llamamos al servicio para obtener el cómic por slug
    // Esto consume el endpoint: GET /comics/:slug
    this.comicService.getComic(slug).subscribe({

      // Si la petición es exitosa
      next: (data) => {
        console.log("🟩 Comic recibido:", data);

        // Guardamos el objeto completo del cómic
        // Si el backend incluye 'paginas', aquí también estarán disponibles
        this.comic = data;

        // Desactivamos estado de carga
        this.cargando = false;
      },

      // Si ocurre un error
      error: (err) => {
        console.error("❌ Error cargando comic:", err);
        this.cargando = false;
      }
    });
  }
}