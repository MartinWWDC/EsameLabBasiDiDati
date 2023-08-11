--domini 
CREATE DOMAIN voto AS integer
   CONSTRAINT valid_voto CHECK (VALUE >= 0 AND VALUE <= 30);
CREATE DOMAIN annoDiInsengnamento AS integer
   CONSTRAINT valid_annoDiInsengnamento CHECK (VALUE >= 1 AND VALUE <= 3);

CREATE DOMAIN annoDiInsengnamentoMag AS integer
   CONSTRAINT valid_annoDiInsengnamento CHECK (VALUE >= 1 AND VALUE <= 2);
