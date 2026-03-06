import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { ComicsService } from '../../../services/comics.service';

@Component({
  selector: 'app-comic-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './comic-form.component.html'
})
export class ComicFormComponent {

  comic = {
    titulo: '',
    descripcion: ''
  };

  saving = false;

  constructor(
    private comicService: ComicsService,
    private router: Router
  ) {}

  submit(): void {
    this.saving = true;

    this.comicService.createMyComic(this.comic).subscribe({
      next: () => {
        this.router.navigate(['/panel/autor/comics']);
      },
      error: (err) => {
        console.error('Error guardando cómic', err);
        this.saving = false;
      }
    });
  }
}
