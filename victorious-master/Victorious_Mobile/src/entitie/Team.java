/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package entitie;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Objects;

/**
 *
 * @author jasser
 */
public class Team {
    private int Id_Team;
     String Team_Name;
    private int Nb_Players;
    private String Players;
    private String Favorite_Games;
    private String Team_Desciption ;
    private String Password ;
    private String Team_Mail;
    private String logo;

    public Team() {
    }

    public Team(String Team_Name, int Nb_Players, String Players, String Favorite_Games, String Team_Desciption, String Password, String Team_Mail, String logo) {
        this.Team_Name = Team_Name;
        this.Nb_Players = Nb_Players;
        this.Players = Players;
        this.Favorite_Games = Favorite_Games;
        this.Team_Desciption = Team_Desciption;
        this.Password = Password;
        this.Team_Mail = Team_Mail;
        this.logo = logo;
    }

    public Team(String Team_Name, String Players, String Favorite_Games, String Team_Desciption, String Password, String Team_Mail, String logo) {
        this.Team_Name = Team_Name;
        this.Players = Players;
        this.Favorite_Games = Favorite_Games;
        this.Team_Desciption = Team_Desciption;
        this.Password = Password;
        this.Team_Mail = Team_Mail;
        this.logo = logo;
    }

    public Team(int Id_Team, String Team_Name, int Nb_Players,String Players,String Favorite_Games, String Team_Desciption, String Password,String logo) {
        this.Id_Team = Id_Team;
        this.Team_Name = Team_Name;
        this.Nb_Players = Nb_Players;
        this.Players = Players;
        this.Favorite_Games = Favorite_Games;
        this.Team_Desciption = Team_Desciption;
        this.Password = Password;
        this.Team_Mail = Team_Mail;
        this.logo=logo;
    }

    public int getId_Team() {
        return Id_Team;
    }

    public String getLogo() {
        return logo;
    }

    public void setLogo(String logo) {
        this.logo = logo;
    }

    public void setId_Team(int Id_Team) {
        this.Id_Team = Id_Team;
    }

    public String getTeam_Name() {
        return Team_Name;
    }

    public void setTeam_Name(String Team_Name) {
        this.Team_Name = Team_Name;
    }

    public int getNb_Players() {
        return Nb_Players;
    }

    public void setNb_Player(int Nb_Players) {
        this.Nb_Players = Nb_Players;
    }

    public String getPlayers() {
        return Players;
    }

    public void setPlayers(String Players) {
        this.Players = Players;
    }

    public String getFavorite_Games() {
        return Favorite_Games;
    }

    public void setFavorite_Games(String Favorite_Games) {
        this.Favorite_Games = Favorite_Games;
    }

    public String getTeam_Desciption() {
        return Team_Desciption;
    }

    public void setTeam_Desciption(String Team_Desciption) {
        this.Team_Desciption = Team_Desciption;
    }

    public String getPassword() {
        return Password;
    }

    public void setPassword(String Password) {
        this.Password = Password;
    }

    public String getTeam_Mail() {
        return Team_Mail;
    }

    public void setTeam_Mail(String Team_Mail) {
        this.Team_Mail = Team_Mail;
    }

    @Override
    public String toString() {
        return "Team{" + "Id_Team=" + Id_Team + ", Team_Name=" + Team_Name + ", Nb_Player=" + Nb_Players + ", Players=" + Players + ", Favorite_Games=" + Favorite_Games + ", Team_Desciption=" + Team_Desciption + ", Password=" + Password + ", Team_Mail=" + Team_Mail + '}';
    }

    @Override
    public int hashCode() {
        int hash = 3;
        hash = 19 * hash + this.Id_Team;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (this == obj) {
            return true;
        }
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Team other = (Team) obj;
        if (this.Id_Team != other.Id_Team) {
            return false;
        }
        if (this.Nb_Players != other.Nb_Players) {
            return false;
        }
        if (!Objects.equals(this.Team_Name, other.Team_Name)) {
            return false;
        }
        if (!Objects.equals(this.Favorite_Games, other.Favorite_Games)) {
            return false;
        }
        if (!Objects.equals(this.Team_Desciption, other.Team_Desciption)) {
            return false;
        }
        if (!Objects.equals(this.Password, other.Password)) {
            return false;
        }
        if (!Objects.equals(this.Team_Mail, other.Team_Mail)) {
            return false;
        }
        if (!Objects.equals(this.Players, other.Players)) {
            return false;
        }
        return true;
    }

    

  
    
}
