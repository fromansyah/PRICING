function Time = ID3(fName,FCT,LDT,Class)

delete('C:\MATLAB701\work\Rule.xls');

[data, textdata] = xlsread(fName);

MF_ATR = Find_ATR(textdata);

size_MF_ATR = size(MF_ATR);

for i=1:size_MF_ATR(2)
    ATR(i) = i;
    Num_MF(i) = MF_ATR(i)+1;
end

tic

ID_tiga(ATR,textdata,data,Num_MF,FCT,LDT,0,[],Class)

Time = toc;

%A = {'The Rules'};
%B = {'Result Class: NO'};
%C = {'Result Class: YES'};

%xlswrite('Rule.xls', A, 'Rule', 'A1');
%xlswrite('Rule.xls', B, 'Rule', 'G1');
%xlswrite('Rule.xls', C, 'Rule', 'H1');

the_Rule = importdata('Rule.mat');
the_Degree = importdata('Degree.mat');

delete('C:\MATLAB701\work\Rule.mat');
delete('C:\MATLAB701\work\Degree.mat');

[data2, textdata2] = xlsread('Rule.xls','Code_Atribut');

size_the_Rule = size(the_Rule);
size_textdata2 = size(textdata2);
size_the_Degree = size(the_Degree);

for i=1:size_the_Rule(1)
    for j=1:size_MF_ATR(2)+1
        if(j<=size_MF_ATR(2))
            code_Rule(i,j) = 0;
        else
            max = the_Degree(i,1);
            code_Rule(i,(size_MF_ATR(2))+1) = 1;
            for k=2:size_the_Degree(2)
                if(the_Degree(i,k)>max)
                    code_Rule(i,(size_MF_ATR(2))+1) = k;
                    max = the_Degree(i,k);
                end
            end
        end   
    end
end


x = 1;
for i=1:size_the_Rule(1)
    for j=1:size_the_Rule(2)+1
        if(j<=size_the_Rule(2))
            k = 1;
            stop = 0;
            while (k<=size_textdata2(1) && stop==0)
                if(strcmp(the_Rule(i,j),textdata2(k,2))==1)
                    tes = mod(data2(k,1),10);
                    if(tes~=0)
                        code_Rule(i,Column) = tes;
                    else
                        Column = data2(k,1)/10;
                    end
                    stop = 1;
                end
                k = k+1;
            end
        else
            %max = the_Degree(i,1);
            %code_Rule(i,(size_the_Rule(2)/2)+1) = 1;
            %cek = 1;
            %for k=2:size_the_Degree(2)
                %if(the_Degree(i,k)>=max)
                    %code_Rule(i,(size_MF_ATR)+1) = k;
                    %cek = k;
                    %max = the_Degree(i,k);
                %end
            %end
            %for m=cek+1:size_the_Degree(2)
                %if(the_Degree(i,m)==max)
                    %for l=1:size_MF_ATR(2)
                        %code_Rule(size_the_Rule(1)+x,l) = code_Rule(i,l);
                    %end
                    %code_Rule(size_the_Rule(1)+x,(size_the_Rule(2)/2)+1) = m;
                    %x = x + 1;
                %end
           %end
        end
    end
end

%code_Rule = code_Rule

for i=1:size_MF_ATR(2)
    if(i==1)
        Name_ATR(i) = textdata2(i,2);
        c = i;
    else
        Name_ATR(i) = textdata2(Num_MF(i-1)+c,2);
        c = c + Num_MF(i-1);
    end
end

A = 'The Rule';
H1 = {A};
H2 = [];
for i=1:size_the_Degree(2)
    H2 = [H2;'Class',int2str(i)];
end
%H2 = H2
H2 = cellstr(H2);
H2 = transpose(H2);
    
xlswrite('Rule.xls', H1, 'Rule', 'A1');
xlswrite('Rule.xls', the_Rule, 'Rule', 'A2');

D = {'CLASS'};

if(size_MF_ATR(2)==1)
    xlswrite('Rule.xls', H2, 'Rule', 'C1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'C2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'B1');
elseif(size_MF_ATR(2)==2)
    xlswrite('Rule.xls', H2, 'Rule', 'E1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'E2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'C1');
elseif(size_MF_ATR(2)==3)
    xlswrite('Rule.xls', H2, 'Rule', 'G1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'G2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'D1');
elseif(size_MF_ATR(2)==4)
    xlswrite('Rule.xls', H2, 'Rule', 'I1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'I2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'E1');
elseif(size_MF_ATR(2)==5)
    xlswrite('Rule.xls', H2, 'Rule', 'K1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'K2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'F1');
elseif(size_MF_ATR(2)==6)
    xlswrite('Rule.xls', H2, 'Rule', 'M1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'M2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'G1');
elseif(size_MF_ATR(2)==7)
    xlswrite('Rule.xls', H2, 'Rule', 'O1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'O2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'H1');
elseif(size_MF_ATR(2)==8)
    xlswrite('Rule.xls', H2, 'Rule', 'Q1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'Q2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'I1');
elseif(size_MF_ATR(2)==9)
    xlswrite('Rule.xls', H2, 'Rule', 'S1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'S2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'J1');
elseif(size_MF_ATR(2)==10)
    xlswrite('Rule.xls', H2, 'Rule', 'U1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'U2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'K1');
elseif(size_MF_ATR(2)==11)
    xlswrite('Rule.xls', H2, 'Rule', 'W1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'W2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'L1');
elseif(size_MF_ATR(2)==12)
    xlswrite('Rule.xls', H2, 'Rule', 'Y1');
    xlswrite('Rule.xls', the_Degree, 'Rule', 'Y2');
    xlswrite('Rule.xls', D, 'Code_Rule', 'M1');
end

xlswrite('Rule.xls', Name_ATR, 'Code_Rule', 'A1');

xlswrite('Rule.xls', code_Rule, 'Code_Rule','A2');



