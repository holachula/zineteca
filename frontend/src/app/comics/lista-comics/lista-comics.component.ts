import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { ComicsService } from '../../services/comics.service';

@Component({
  selector: 'app-lista-comics',
  standalone: true,
  imports: [CommonModule, RouterModule],   // 👈 AQUI
  templateUrl: './lista-comics.component.html',
  styleUrls: ['./lista-comics.component.scss']
})
export class ListaComicsComponent implements OnInit {

  comics: any[] = [];
  cargando = true;

  constructor(private comicsService: ComicsService) {}

  ngOnInit(): void {
    this.comicsService.getComics().subscribe({
      next: (data) => {
        this.comics = data;
        this.cargando = false;
      },
      error: (error) => {
        console.error('Error cargando comics:', error);
        this.cargando = false;
      }
    });
  }
}