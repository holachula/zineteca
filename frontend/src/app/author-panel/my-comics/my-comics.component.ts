import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Router } from '@angular/router'; // <-- Router para navegación
import { ComicsService } from '../../services/comics.service';
import { AuthService } from '../../auth/auth.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-my-comics',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './my-comics.component.html',
  styleUrls: ['./my-comics.component.scss']
})
export class MyComicsComponent implements OnInit {

  comics: any[] = [];
  loading = true;

  constructor(
    private comicService: ComicsService,
    public auth: AuthService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.loadMyComics();
  }

  loadMyComics(): void {
    this.comicService.getMyComics().subscribe({
      next: (data) => {
        console.log('Comics recibidos', data);
        this.comics = data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Error cargando cómics', err);
        this.loading = false;
      }
    });
  }

  // Botón "Agregar cómic"
  addComic(): void {
    this.router.navigate(['/panel/autor/comics/nuevo']); // ruta para crear nuevo comic
  }

  // Botón "Vista previa"
  viewComic(slug: string): void {
    this.router.navigate(['/comic', slug]);
  }

  // Botón "Editar"
  editComic(slug: string): void {
    this.router.navigate(['/panel/autor/comics', slug, 'editar']); // ruta de edición
  }
}