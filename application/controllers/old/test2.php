function MF_ATR = Find_ATR(header)

size_header = size(header);

Num_MF = [];
Num_ATR = 0;
MF = 0;
for i=2:size_header(2)-1
    ATR(i-1,1) = header(1,i);
    Char1 = char(header(1,i));
    Char1 = Char1(1);
    Char2 = char(header(1,i));
    Char2 = Char2(2);
    if( strcmp(Char1,'M')==1 && strcmp(Char2,'F')==1 )
        MF = MF+1;
        Num_MF(Num_ATR) = MF;
        code_ATR(i-1,1) = (Num_ATR*10)+MF;
    else
        Num_ATR = Num_ATR+1;
        code_ATR(i-1,1) = Num_ATR*10;
        MF = 0;
    end
end

size_code_ATR = size(code_ATR);

range1 = ['A1:A',int2str(size_code_ATR(1))];
range1 = char(range1);
range2 = ['B1:B',int2str(size_code_ATR(1))];
range2 = char(range2);

xlswrite('Rule.xls', code_ATR, 'Code_Atribut', range1);
xlswrite('Rule.xls', ATR, 'Code_Atribut', range2);

MF_ATR = Num_MF;
    