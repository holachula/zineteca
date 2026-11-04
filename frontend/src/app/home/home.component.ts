/*
|--------------------------------------------------------------------------
| File: src/app/home/home.component.ts
|--------------------------------------------------------------------------
| Componente principal del Home.
|
| Funcionalidades:
| - Mostrar comics y autores
| - Tabs de navegación (Comics / Autores)
| - Randomización de comics
| - Filtros locales con selects dinámicos:
|   - Genero
|   - Temática
|   - Año
|   - Estado
| - Aplicar múltiples filtros a la vez
| - Cargar listas dinámicas para selects desde la API
| - Limpiar todos los filtros
| - Eliminar filtros individuales (tags)
|--------------------------------------------------------------------------
*/

import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HomeService } from '../services/home.service';
import { RouterModule } from '@angular/router';
import { Comic } from '../models/comic.model';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule,
    RouterModule,  FormsModule],
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  // ================================
  // CONTROL DE TABS (PILLS)
  // ================================
  activeTab: 'comics' | 'autores' = 'comics';

  // ================================
  // DATA PRINCIPAL
  // ================================
  comics: Comic[] = [];          // Comics que se muestran en pantalla
  originalComics: any[] = [];   // Copia base SIN modificar

  autores: any[] = [];           // Autores en pantalla
  originalAutores: any[] = [];   // Copia base autores

  // ================================
  // FILTROS SELECCIONABLES
  // ================================
  filters = {
    genero: '',
    tematica: '',
    anio: '',
    estado: ''
  };

  // ================================
  // LISTAS DINÁMICAS PARA SELECTS
  // ================================
  generos: any[] = [];
  tematicas: any[] = [];
  estados: string[] = [];
  anios: number[] = [];

  constructor(private homeService: HomeService) {}

  // ================================
  // CARGA INICIAL
  // ================================
  ngOnInit(): void {

    // 1️⃣ Traemos TODOS los comics del backend
    this.homeService.getComics().subscribe(res => {
      this.originalComics = res;

      // Randomizamos SOLO UNA VEZ al entrar a la página
      this.comics = this.shuffle(res);
    });

    // 2️⃣ Traemos autores
    this.homeService.getAutores().subscribe(res => {
      this.originalAutores = res;
      this.autores = res;
    });

    // 3️⃣ Cargamos datos para selects dinámicos
    this.homeService.getGeneros().subscribe(res => this.generos = res);
    this.homeService.getTematicas().subscribe(res => this.tematicas = res);
    this.homeService.getEstados().subscribe(res => this.estados = res);
    this.homeService.getAnios().subscribe(res => this.anios = res);
  }

  // ================================
  // FUNCIÓN SHUFFLE (RANDOM FRONTEND)
  // ================================
  shuffle(array: any[]): any[] {
    // Clonamos el array y lo desordenamos
    return [...array].sort(() => Math.random() - 0.5);
  }

  // ================================
  // BOTÓN 🎲 RANDOMIZAR
  // ================================
  randomize(): void {
    // Solo reordena lo que ya está en memoria
    this.comics = this.shuffle(this.comics);
  }

  // ================================
  // FILTROS DE COMICS (LOCAL)
  // ================================
  applyComicFilters(): void {

    // Siempre filtramos desde la copia original
    let filtered = [...this.originalComics];

    if (this.filters.genero) {
      filtered = filtered.filter(c =>
        c.generos?.some((g: any) => g.nombre === this.filters.genero)
      );
    }

    if (this.filters.tematica) {
      filtered = filtered.filter(c =>
        c.tematicas?.some((t: any) => t.nombre === this.filters.tematica)
      );
    }

    if (this.filters.anio) {
      filtered = filtered.filter(c =>
        c.anio == this.filters.anio
      );
    }

    if (this.filters.estado) {
      filtered = filtered.filter(c =>
        c.autor?.estado === this.filters.estado
      );
    }

    this.comics = filtered;
  }

  // ================================
  // FILTROS DE AUTORES (LOCAL)
  // ================================
  applyAutorFilters(): void {

    let filtered = [...this.originalAutores];

    if (this.filters.estado) {
      filtered = filtered.filter(a =>
        a.estado === this.filters.estado
      );
    }

    this.autores = filtered;
  }

  // ================================
  // LIMPIAR TODOS LOS FILTROS
  // ================================
  clearFilters(): void {
    this.filters = { genero: '', tematica: '', anio: '', estado: '' };
    this.comics = [...this.originalComics];
    this.autores = [...this.originalAutores];
  }

  // ================================
  // CAMBIO DE TAB (NO REFETCH)
  // ================================
  changeTab(tab: 'comics' | 'autores'): void {
    // Solo cambia el estado visual
    this.activeTab = tab;

    // ❌ NO volvemos a llamar al backend
    // ❌ NO volvemos a randomizar automáticamente
  }

  // ================================
  // ELIMINAR FILTRO INDIVIDUAL
  // ================================
  removeFilter(key: keyof typeof this.filters): void {
    // Limpiamos el filtro individual
    this.filters[key] = '';

    // Re-aplicamos filtros dependiendo del tab activo
    if (this.activeTab === 'comics') this.applyComicFilters();
    else this.applyAutorFilters();
  }
  // Devuelve las keys de filtros activos correctamente tipadas
get activeFilterKeys(): (keyof typeof this.filters)[] {
  return (['genero', 'tematica', 'anio', 'estado'] as (keyof typeof this.filters)[])
    .filter(key => !!this.filters[key]);
}


}