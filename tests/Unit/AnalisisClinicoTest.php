<?php

namespace Tests\Unit;

use DateTime;

use PHPUnit\Framework\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use Faker\Factory;
use Mod2Nur\Dominio\Diagnostico\AnalisisClinico;

class AnalisisClinicoTest extends TestCase
{
    public function testConstructorAceptaUuidValido()
    {
        //Arrange
        $faker = Factory::create();
        $idValido = Uuid::uuid4()->toString();
        $fechaString =  $faker->date();
        $fechaRealizacion = new DateTime( $fechaString );
        $observaciones =  $faker->word(); 
        $conclusion = $faker->sentence();
        //Act
        $analisisClinico = new AnalisisClinico($idValido, $fechaRealizacion, $observaciones, $conclusion);
        //Assert
        $this->assertSame($idValido, $analisisClinico->getId(), 'El constructor no asignó correctamente un UUID válido.');
    }

    public function testConcluirAnalisis()
    {
       //Arrange
       $faker = Factory::create();
       $idValido = Uuid::uuid4()->toString();
       $fechaString =  $faker->date();
       $fechaRealizacion = new DateTime( $fechaString );
       $observaciones =  $faker->word(); 
       $conclusion = $faker->sentence();
       //Act
       $analisisClinico = new AnalisisClinico($idValido, $fechaRealizacion, $observaciones, $conclusion);
       $analisisClinico->concluirAnalisis();
       //Assert
       $this->assertTrue($analisisClinico->isConcluido());
   }

    
}