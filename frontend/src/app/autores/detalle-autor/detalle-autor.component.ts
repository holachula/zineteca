import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { AutoresService } from '../../services/autores.service';

@Component({
  selector: 'app-detalle-autor',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './detalle-autor.component.html',
  styleUrls: ['./detalle-autor.component.scss']
})
export class DetalleAutorComponent implements OnInit {

  autor: any = null;
  cargando = true;

  constructor(
    private route: ActivatedRoute,
    private autoresService: AutoresService
  ) {}

  ngOnInit(): void {
    const slug = this.route.snapshot.paramMap.get('slug');

    if (!slug) {
      console.error("❌ No se recibió slug en la URL");
      this.cargando = false;
      return;
    }

    console.log("🟦 Slug recibido en detalle:", slug);

    this.autoresService.getAutor(slug).subscribe({
      next: (data) => {
        console.log("🟩 Autor recibido:", data);
        this.autor = data;
        this.cargando = false;
      },
      error: (err) => {
        console.error("❌ Error cargando autor:", err);
        this.cargando = false;
      }
    });
  }

  // Métodos auxiliares fuera de ngOnInit (ya son métodos de la clase)
  getGeneros(comic: any): string {
    if (!comic?.generos || !Array.isArray(comic.generos)) return '';
    return comic.generos.map((g: any) => g.nombre).join(', ');
  }

  getTematicas(comic: any): string {
    if (!comic?.tematicas || !Array.isArray(comic.tematicas)) return '';
    return comic.tematicas.map((t: any) => t.nombre).join(', ');
  }

}
