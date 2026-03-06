// frontend/src/app/autores/lista-autores/lista-autores.component.ts

// Importaciones necesarias de Angular
import { Component, OnInit } from '@angular/core';

// CommonModule permite usar directivas comunes en el HTML como *ngIf y *ngFor
import { CommonModule } from '@angular/common';

// RouterModule permite usar enlaces de navegación como routerLink en el template
import { RouterModule } from '@angular/router';

// Servicio que se encarga de comunicarse con el backend para obtener autores
import { AutoresService } from '../../services/autores.service';

/**
 * Decorador @Component
 * Define la configuración del componente:
 * - selector: nombre de la etiqueta HTML para usar el componente
 * - standalone: indica que es un componente independiente (Angular moderno)
 * - imports: módulos que el componente puede usar en su template
 * - templateUrl: archivo HTML asociado
 * - styleUrls: archivo(s) de estilos asociados
 */
@Component({
  selector: 'app-lista-autores',
  standalone: true,
  imports: [CommonModule, RouterModule],   // Permite usar directivas comunes y rutas en el HTML
  templateUrl: './lista-autores.component.html',
  styleUrls: ['./lista-autores.component.scss']
})

/**
 * Clase del componente que controla la lógica de la lista de autores.
 * Implementa OnInit para ejecutar lógica al inicializar el componente.
 */
export class ListaAutoresComponent implements OnInit {

  // Arreglo donde se guardará la lista de autores recibida del backend
  autores: any[] = [];

  // Bandera para mostrar estado de carga (por ejemplo un spinner en la UI)
  cargando = true;

  /**
   * Constructor del componente
   * Angular inyecta el servicio AutoresService para poder usarlo aquí
   */
  constructor(private autoresService: AutoresService) {}

  /**
   * ngOnInit()
   * Método del ciclo de vida de Angular que se ejecuta
   * automáticamente cuando el componente se inicializa.
   */
  ngOnInit(): void {

    // Llamada al servicio para obtener la lista de autores desde la API
    this.autoresService.getAutores().subscribe({

      // Se ejecuta cuando la petición HTTP responde correctamente
      next: (data) => {
        this.autores = data;   // Guardamos los autores en la variable del componente
        this.cargando = false; // Terminó la carga
      },

      // Se ejecuta si ocurre un error en la petición
      error: (error) => {
        console.error('Error cargando autores:', error); // Muestra error en consola
        this.cargando = false; // Detiene estado de carga aunque haya error
      }

    });
  }
}