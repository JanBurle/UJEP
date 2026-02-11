# re-create the Python virtual environment
rm -rf .venv
python3 -m venv .venv
source .venv/bin/activate
pip install pyside6 psycopg ZODB

echo -e "Run \033[1msource .venv/bin/activate\033[0m to activate virtual environment"
