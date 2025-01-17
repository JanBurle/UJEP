CREATE MIGRATION m1aakyn6bfzggtqcn2sj6qny52hb5hjli24x47lkpmgy3tszqmoteq
    ONTO m1uwekrn4ni4qs7ul7hfar4xemm5kkxlpswolcoyqj3xdhweomwjrq
{
  ALTER TYPE default::Movie {
      ALTER PROPERTY title {
          SET REQUIRED USING ('film');
      };
  };
};
