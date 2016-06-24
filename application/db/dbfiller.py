import sqlite3 as sq
import random
import string
import time



def llenar():
    con = sq.connect('dbqlite_stress.db')
    
    for x in range(30000):
        nom = ''.join([random.choice(string.ascii_letters + string.digits) for n in range(8)])
        ape = ''.join([random.choice(string.ascii_letters + string.digits) for n in range(8)])
        dis = ''.join([random.choice(string.ascii_letters + string.digits) for n in range(8)])
        ema = ''.join([random.choice(string.ascii_letters + string.digits) for n in range(8)])
        conte = ''.join([random.choice(string.ascii_letters + string.digits) for n in range(64)])
        anio = random.randint(1970, 2016)
        can = random.randint(0, 10000)
        usu = random.randint(0, 10000)
        frag = random.randint(0, 40000)
        pun = 0
        
        #IR EJECUTANDOLOS DE A 1 con el rango correspondiente de X
        
        #con.execute("INSERT INTO USUARIO (nombre, apellido, email, puntos) VALUES (?, ?, ?, ?) ", (nom, ape, ema, pun) )
        #con.execute("INSERT INTO CANCION (nombre, anio, disco, artista) VALUES (?, ?, ?, ?) ", (dis, anio, nom, ape) )
        #con.execute("INSERT INTO FRAGMENTO (codigo_cancion, codigo_usuario, contenido) VALUES (?, ?, ?) ", (can, usu, conte) )
        #con.execute("INSERT INTO TAG (codigo_cancion, nombre) VALUES (?, ?) ", ( can, ape ) )
        #con.execute("INSERT INTO JUEGO (codigo_usuario, codigo_fragmento, dificultad, puntaje) VALUES (?, ?, ?, ?) ", (usu, frag, nom, anio) )
        
        #time.sleep(1)
        
    con.commit()
    
    con.close()
    
    
    
    
    
llenar()