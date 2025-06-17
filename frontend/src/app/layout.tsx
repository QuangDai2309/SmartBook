import './globals.css';
import Header from './components/Header/Header';

export const metadata = {
  title: 'Waka Web',
  description: 'Trang đọc sách Waka clone',
};

export default function RootLayout({ children }) {
  return (
    <html lang="vi">
      <body>
        <Header />
        <main className="main-content">
          {children}
        </main>
      </body>
    </html>
  );
}
