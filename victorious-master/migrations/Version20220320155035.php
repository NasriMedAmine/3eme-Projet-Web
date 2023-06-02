<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320155035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leader DROP FOREIGN KEY leader_ibfk_1');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY idUserd');
        $this->addSql('ALTER TABLE leader DROP FOREIGN KEY leader_ibfk_2');
        $this->addSql('ALTER TABLE publicite_aimer DROP FOREIGN KEY id_user');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY idUser');
        $this->addSql('ALTER TABLE res_tournament DROP FOREIGN KEY res_tournament_ibfk_1');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE advertise');
        $this->addSql('DROP TABLE bracet');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE layertournament');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE message_reclam');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE publicite_aimer');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE res_tournament');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE society');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE publicite MODIFY id_publicite INT NOT NULL');
        $this->addSql('ALTER TABLE publicite DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE publicite ADD description VARCHAR(5000) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE nom_proprietaire nom_proprietaire VARCHAR(255) NOT NULL, CHANGE id_publicite id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE publicite ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (Id_Admin INT AUTO_INCREMENT NOT NULL, Pseudo VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Admin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE advertise (Id_Advertise INT AUTO_INCREMENT NOT NULL, Name_society VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Date_Debut DATE NOT NULL, Date_Fin DATE NOT NULL, PRIMARY KEY(Id_Advertise)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bracet (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_tournoi INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE chat (Id_Chat INT AUTO_INCREMENT NOT NULL, Message VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, id_user INT NOT NULL, id_tournoi INT NOT NULL, PRIMARY KEY(Id_Chat)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE demande (idDemande INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, nomSociete TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, adresseSociete TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, codeTVA TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, typeDemandeur TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, valide TINYINT(1) DEFAULT 0 NOT NULL, INDEX idUserd (idUser), PRIMARY KEY(idDemande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE games (Id_Game INT AUTO_INCREMENT NOT NULL, Game_Name VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Description VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, News VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, News_Date DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, Image TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Game)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE layertournament (id INT AUTO_INCREMENT NOT NULL, id_tournoi INT DEFAULT NULL, id_user INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE leader (Id_Leader INT AUTO_INCREMENT NOT NULL, Id_Player INT NOT NULL, Id_User INT NOT NULL, Level INT NOT NULL, Pseudo VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Password VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Mail VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX Id_Player (Id_Player), INDEX Id_User (Id_User), PRIMARY KEY(Id_Leader)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `match` (Id_Match INT AUTO_INCREMENT NOT NULL, Date DATE NOT NULL, Teams VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Match)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message_reclam (id INT AUTO_INCREMENT NOT NULL, id_reclam INT NOT NULL, id_send INT NOT NULL, message TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE news (Id_News INT AUTO_INCREMENT NOT NULL, Title VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Content VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Image TINYTEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(Id_News)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE player (Id_Player INT AUTO_INCREMENT NOT NULL, Level INT NOT NULL, Pseudo VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Teams VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Password VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Mail VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(Id_Player)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE publicite_aimer (id_pub_aimer INT AUTO_INCREMENT NOT NULL, id_publicite INT NOT NULL, id_user INT NOT NULL, date DATE NOT NULL, INDEX id_user (id_user), INDEX id_publicite (id_publicite), PRIMARY KEY(id_pub_aimer)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reclamation (idReclamation INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, message TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, objet TINYTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, answer VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NO\' NOT NULL COLLATE `utf8mb4_general_ci`, INDEX idUser (idUser), PRIMARY KEY(idReclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE res_tournament (Id_Res INT AUTO_INCREMENT NOT NULL, Id_User INT NOT NULL, Pseudo VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Password VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Mail VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX pk_Id_User (Id_User), PRIMARY KEY(Id_Res)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE result (Id_Result INT AUTO_INCREMENT NOT NULL, Win_Teams VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Lose_Teams VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Result)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE society (Id_Society INT AUTO_INCREMENT NOT NULL, Name VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Registration_Number INT NOT NULL, PRIMARY KEY(Id_Society)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE team (Id_Team INT AUTO_INCREMENT NOT NULL, Team_Name VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Nb_Players INT NOT NULL, Players VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Favorite_Games VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Team_Desciption VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Password VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Team_Mail VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, logo MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Team)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket (Id_Ticket INT AUTO_INCREMENT NOT NULL, User VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Admin VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Ticket)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tournament (Id_Tournament INT AUTO_INCREMENT NOT NULL, Tournament_Name VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, id_Managers INT NOT NULL, code VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_game INT NOT NULL, type VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(Id_Tournament)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (Id INT AUTO_INCREMENT NOT NULL, Pseudo VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Password VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Mail VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, DateOfBirth DATE NOT NULL, Image TINYTEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, role INT NOT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT idUserd FOREIGN KEY (idUser) REFERENCES user (Id)');
        $this->addSql('ALTER TABLE leader ADD CONSTRAINT leader_ibfk_2 FOREIGN KEY (Id_User) REFERENCES user (Id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE leader ADD CONSTRAINT leader_ibfk_1 FOREIGN KEY (Id_Player) REFERENCES player (Id_Player) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publicite_aimer ADD CONSTRAINT id_user FOREIGN KEY (id_user) REFERENCES user (Id)');
        $this->addSql('ALTER TABLE publicite_aimer ADD CONSTRAINT id_publicite FOREIGN KEY (id_publicite) REFERENCES publicite (id_publicite)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT idUser FOREIGN KEY (idUser) REFERENCES user (Id)');
        $this->addSql('ALTER TABLE res_tournament ADD CONSTRAINT res_tournament_ibfk_1 FOREIGN KEY (Id_User) REFERENCES user (Id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publicite MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE publicite DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE publicite DROP description, CHANGE nom nom TINYTEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image TINYTEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE nom_proprietaire nom_proprietaire TINYTEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE id id_publicite INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE publicite ADD PRIMARY KEY (id_publicite)');
    }
}
