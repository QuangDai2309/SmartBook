import axios from "axios";
export const BASE_URL = 'http://localhost:8000/api';

// ========== ĐĂNG NHẬP BẰNG EMAIL ==========
export const apiLoginUser = async (email, password) => {
  try {
    const response = await axios.post(`${BASE_URL}/login`, {
      email,
      password,
    });
    return response.data;
  } catch (error) {
    throw new Error(error.response?.data?.message || 'Đăng nhập thất bại');
  }
};

// ========== ĐĂNG NHẬP GOOGLE ==========
// Đặt ở đầu file hoặc import từ config

export const apiLoginWithGoogle = async (googleToken) => {
  try {
    const response = await axios.post(`${BASE_URL}/login/google`, {
      token: googleToken,
    });
    return response.data;
  } catch (error) {
    console.error('Google Login API Error:', error.response?.data || error.message);
    throw new Error(error.response?.data?.message || 'Đăng nhập Google thất bại');
  }
};


// ========== ĐĂNG KÝ ==========
export const apiRegisterUser = async (name, email, password, password_confirmation) => {
  try {
    const response = await axios.post(`${BASE_URL}/register`, {
      name,
      email,
      password,
      password_confirmation,
    });
    return response.data;
  } catch (error) {
    throw new Error(error.response?.data?.message || 'Đăng ký thất bại');
  }
};

// ========== QUÊN MẬT KHẨU ==========
export const apiForgotPassword = async (email) => {
  try {
    const response = await axios.post(`${BASE_URL}/forgot-password`, {
      email,
    });
    return response.data;
  } catch (error) {
    throw new Error(error.response?.data?.message || 'Lỗi khôi phục mật khẩu');
  }
};

// ========== ĐẶT LẠI MẬT KHẨU ==========
export const apiResetPassword = async ({ email, token, password, password_confirmation }) => {
  try {
    const response = await axios.post(`${BASE_URL}/reset-password`, {
      email,
      token,
      password,
      password_confirmation,
    });
    return response.data;
  } catch (error) {
    throw new Error(error.response?.data?.message || 'Đặt lại mật khẩu thất bại');
  }
};

// ========== LẤY THÔNG TIN USER SAU ĐĂNG NHẬP ==========
export const apiGetMe = async () => {
  const token = localStorage.getItem('token');

  const res = await axios.get('http://localhost:8000/api/me', {
    headers: {
      Authorization: `Bearer ${token}`,
      Accept: 'application/json',
    },
  });

  return res.data;
};

// ========== TÌM KIẾM SÁCH ==========
export const apiSearchBooks = async (params = {}) => {
  try {
    const query = new URLSearchParams(params).toString();
    const response = await axios.get(`${BASE_URL}/books/search?${query}`);
    return response.data;
  } catch (error) {
    throw new Error('Lỗi tìm kiếm sách');
  }
};

// ========== LẤY TÁC GIẢ ==========
export const apiGetAuthors = async () => {
  try {
    const response = await axios.get(`${BASE_URL}/authors`);
    return response.data;
  } catch (error) {
    return { status: 'error', data: [] };
  }
};

// ========== LẤY DANH MỤC ==========
export const apiGetCategories = async () => {
  try {
    const response = await axios.get(`${BASE_URL}/categories`);
    return response.data;
  } catch (error) {
    return { status: 'error', data: [] };
  }
};
