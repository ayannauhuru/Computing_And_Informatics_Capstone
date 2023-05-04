import logging, coloredlogs
from sqlalchemy.orm import scoped_session, sessionmaker
from sqlalchemy.engine import Engine
from sqlalchemy.exc import SQLAlchemyError
from sqlalchemy.engine.cursor import CursorResult
from sqlalchemy.sql import text
from sqlalchemy import create_engine

from typing import Dict, Any, Optional

class Database:
    def __init__(self):
        url = f"mysql://capstone:capstone@localhost/capstone?charset=utf8mb4"
        engine = create_engine(url, pool_recycle=3600)
        session = sessionmaker(bind=engine, autoflush=True, autocommit=True)
        self.conn = scoped_session(session)

        self.logger = logging.getLogger("db")
        log_fmt_str = "[%(asctime)s] %(levelname)s | Database | %(message)s"
        log_fmt = logging.Formatter(log_fmt_str)
        fileHandler = logging.FileHandler("{0}/{1}.log".format("log", "db"), encoding="utf-8")
        fileHandler.setFormatter(log_fmt)
        
        consoleHandler = logging.StreamHandler()
        consoleHandler.setFormatter(log_fmt)

        self.logger.addHandler(fileHandler)
        self.logger.addHandler(consoleHandler)
        
        self.logger.setLevel(logging.INFO)
        coloredlogs.install(logging.INFO, logger=self.logger, fmt=log_fmt_str)


    def put_translation(self, text1: str, text2: str) -> Optional[int]:
        sql = "INSERT INTO milestone2 VALUES (DEFAULT, :text1, :text2) ON DUPLICATE KEY UPDATE text2 = VALUES(text2)"

        result = self.execute(sql, {"text1": text1, "text2": text2})

        if result is None: return None
        return result.lastrowid
    
    def execute(self, sql: str, opts: Dict[str, Any]={}) -> Optional[CursorResult]:
        self.logger.info(f"SQL Execute: {sql} {opts}")

        try:
            res = self.conn.execute(text(sql), opts)

        except SQLAlchemyError as e:
            self.logger.error(f"SQLAlchemy error {e}")
            return None
            
        return res