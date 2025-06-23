import './globals.css';
import ConditionalHeader from './components/ConditionalHeader';
import { GoogleOAuthProvider } from '@react-oauth/google';

export const metadata = {
  title: 'Waka Web',
  description: 'Trang đọc sách Waka clone',
};

export default function RootLayout({ children }) {
  return (
    <html lang="vi">
      <body>
        <GoogleOAuthProvider clientId={process.env.NEXT_PUBLIC_GOOGLE_CLIENT_ID}>
          <ConditionalHeader />
          <main className="main-content">{children}</main>
        </GoogleOAuthProvider>
      </body>
    </html>
  );
}
