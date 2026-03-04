import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetalleComicComponent } from './detalle-comic.component';

describe('DetalleComicComponent', () => {
  let component: DetalleComicComponent;
  let fixture: ComponentFixture<DetalleComicComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DetalleComicComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DetalleComicComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
