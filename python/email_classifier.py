# email_classifier.py
import pandas as pd
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.naive_bayes import MultinomialNB
import joblib
import os
import sys

MODEL_PATH = "python/model.pkl"
VEC_PATH = "python/vectorizer.pkl"
CSV_PATH = "php-backend/data/emails.csv"

def train_model():
    df = pd.read_csv(CSV_PATH)
    df = df.dropna(subset=['label'])
    if df.empty or df['label'].isnull().all():
        print("No training data available.")
        return None, None
    df['text'] = df['subject'] + ' ' + df['body']
    X = CountVectorizer().fit_transform(df['text'])
    y = df['label']
    vec = CountVectorizer()
    X = vec.fit_transform(df['text'])
    model = MultinomialNB()
    model.fit(X, y)
    joblib.dump(model, MODEL_PATH)
    joblib.dump(vec, VEC_PATH)
    print("✅ Model re-trained and saved.")
    return model, vec

def classify(subject, body):
    if not os.path.exists(MODEL_PATH) or not os.path.exists(VEC_PATH):
        print("Model not found. Training...")
        return train_model()

    model = joblib.load(MODEL_PATH)
    vec = joblib.load(VEC_PATH)
    text = [subject + ' ' + body]
    X_test = vec.transform(text)
    return model.predict(X_test)[0]

if __name__ == "__main__":
    if len(sys.argv) == 3:
        subject, body = sys.argv[1], sys.argv[2]
        label = classify(subject, body)
        print(label)
    elif len(sys.argv) == 2 and sys.argv[1] == "train":
        train_model()
