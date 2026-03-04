import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { AutoresService } from '../../services/autores.service';

@Component({
  selector: 'app-lista-autores',
  standalone: true,
  imports: [CommonModule, RouterModule],   // 👈 AQUI
  templateUrl: './lista-autores.component.html',
  styleUrls: ['./lista-autores.component.scss']
})
export class ListaAutoresComponent implements OnInit {

  autores: any[] = [];
  cargando = true;

  constructor(private autoresService: AutoresService) {}

  ngOnInit(): void {
    this.autoresService.getAutores().subscribe({
      next: (data) => {
        this.autores = data;
        this.cargando = false;
      },
      error: (error) => {
        console.error('Error cargando autores:', error);
        this.cargando = false;
      }
    });
  }
}
