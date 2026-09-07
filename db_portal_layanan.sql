--
-- PostgreSQL database dump
--

\restrict YlOHoCojmNrFbEtEqbeLWg1i3yakxbhWEkmxdTPmQujnBztzTulapL5CNzI9Dbl

-- Dumped from database version 18.4
-- Dumped by pg_dump version 18.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_kecamatan_id_foreign;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_desa_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_verified_by_desa_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_user_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_service_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_kecamatan_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_desa_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submission_documents DROP CONSTRAINT IF EXISTS submission_documents_submission_id_foreign;
ALTER TABLE IF EXISTS ONLY public.submission_documents DROP CONSTRAINT IF EXISTS submission_documents_service_requirement_id_foreign;
ALTER TABLE IF EXISTS ONLY public.service_requirements DROP CONSTRAINT IF EXISTS service_requirements_service_id_foreign;
ALTER TABLE IF EXISTS ONLY public.desas DROP CONSTRAINT IF EXISTS desas_kecamatan_id_foreign;
DROP INDEX IF EXISTS public.users_kecamatan_id_role_index;
DROP INDEX IF EXISTS public.submissions_user_id_status_index;
DROP INDEX IF EXISTS public.submissions_service_id_kecamatan_id_index;
DROP INDEX IF EXISTS public.submissions_kecamatan_id_status_index;
DROP INDEX IF EXISTS public.submissions_desa_id_status_index;
DROP INDEX IF EXISTS public.submission_documents_submission_id_status_validasi_index;
DROP INDEX IF EXISTS public.sessions_user_id_index;
DROP INDEX IF EXISTS public.sessions_last_activity_index;
DROP INDEX IF EXISTS public.service_requirements_service_id_urutan_index;
DROP INDEX IF EXISTS public.jobs_queue_index;
DROP INDEX IF EXISTS public.failed_jobs_connection_queue_failed_at_index;
DROP INDEX IF EXISTS public.desas_kecamatan_id_index;
DROP INDEX IF EXISTS public.cache_locks_expiration_index;
DROP INDEX IF EXISTS public.cache_expiration_index;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_pkey;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_nik_unique;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_email_unique;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_pkey;
ALTER TABLE IF EXISTS ONLY public.submissions DROP CONSTRAINT IF EXISTS submissions_nomor_tiket_unique;
ALTER TABLE IF EXISTS ONLY public.submission_documents DROP CONSTRAINT IF EXISTS submission_documents_pkey;
ALTER TABLE IF EXISTS ONLY public.sessions DROP CONSTRAINT IF EXISTS sessions_pkey;
ALTER TABLE IF EXISTS ONLY public.services DROP CONSTRAINT IF EXISTS services_pkey;
ALTER TABLE IF EXISTS ONLY public.services DROP CONSTRAINT IF EXISTS services_kode_layanan_unique;
ALTER TABLE IF EXISTS ONLY public.service_requirements DROP CONSTRAINT IF EXISTS service_requirements_pkey;
ALTER TABLE IF EXISTS ONLY public.password_reset_tokens DROP CONSTRAINT IF EXISTS password_reset_tokens_pkey;
ALTER TABLE IF EXISTS ONLY public.migrations DROP CONSTRAINT IF EXISTS migrations_pkey;
ALTER TABLE IF EXISTS ONLY public.kecamatans DROP CONSTRAINT IF EXISTS kecamatans_pkey;
ALTER TABLE IF EXISTS ONLY public.kecamatans DROP CONSTRAINT IF EXISTS kecamatans_kode_kecamatan_unique;
ALTER TABLE IF EXISTS ONLY public.jobs DROP CONSTRAINT IF EXISTS jobs_pkey;
ALTER TABLE IF EXISTS ONLY public.job_batches DROP CONSTRAINT IF EXISTS job_batches_pkey;
ALTER TABLE IF EXISTS ONLY public.failed_jobs DROP CONSTRAINT IF EXISTS failed_jobs_uuid_unique;
ALTER TABLE IF EXISTS ONLY public.failed_jobs DROP CONSTRAINT IF EXISTS failed_jobs_pkey;
ALTER TABLE IF EXISTS ONLY public.desas DROP CONSTRAINT IF EXISTS desas_pkey;
ALTER TABLE IF EXISTS ONLY public.desas DROP CONSTRAINT IF EXISTS desas_kode_desa_unique;
ALTER TABLE IF EXISTS ONLY public.cache DROP CONSTRAINT IF EXISTS cache_pkey;
ALTER TABLE IF EXISTS ONLY public.cache_locks DROP CONSTRAINT IF EXISTS cache_locks_pkey;
ALTER TABLE IF EXISTS public.users ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.submissions ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.submission_documents ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.services ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.service_requirements ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.migrations ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.kecamatans ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.failed_jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.desas ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE IF EXISTS public.users_id_seq;
DROP TABLE IF EXISTS public.users;
DROP SEQUENCE IF EXISTS public.submissions_id_seq;
DROP TABLE IF EXISTS public.submissions;
DROP SEQUENCE IF EXISTS public.submission_documents_id_seq;
DROP TABLE IF EXISTS public.submission_documents;
DROP TABLE IF EXISTS public.sessions;
DROP SEQUENCE IF EXISTS public.services_id_seq;
DROP TABLE IF EXISTS public.services;
DROP SEQUENCE IF EXISTS public.service_requirements_id_seq;
DROP TABLE IF EXISTS public.service_requirements;
DROP TABLE IF EXISTS public.password_reset_tokens;
DROP SEQUENCE IF EXISTS public.migrations_id_seq;
DROP TABLE IF EXISTS public.migrations;
DROP SEQUENCE IF EXISTS public.kecamatans_id_seq;
DROP TABLE IF EXISTS public.kecamatans;
DROP SEQUENCE IF EXISTS public.jobs_id_seq;
DROP TABLE IF EXISTS public.jobs;
DROP TABLE IF EXISTS public.job_batches;
DROP SEQUENCE IF EXISTS public.failed_jobs_id_seq;
DROP TABLE IF EXISTS public.failed_jobs;
DROP SEQUENCE IF EXISTS public.desas_id_seq;
DROP TABLE IF EXISTS public.desas;
DROP TABLE IF EXISTS public.cache_locks;
DROP TABLE IF EXISTS public.cache;
SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


--
-- Name: desas; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.desas (
    id bigint NOT NULL,
    kecamatan_id bigint NOT NULL,
    kode_desa character varying(15) NOT NULL,
    nama_desa character varying(100) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: COLUMN desas.kode_desa; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.desas.kode_desa IS 'Kode desa (misal: 3206150001)';


--
-- Name: COLUMN desas.nama_desa; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.desas.nama_desa IS 'Nama desa/kelurahan';


--
-- Name: desas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.desas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: desas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.desas_id_seq OWNED BY public.desas.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: kecamatans; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.kecamatans (
    id bigint NOT NULL,
    kode_kecamatan character varying(10) NOT NULL,
    nama_kecamatan character varying(100) NOT NULL,
    alamat_kantor text,
    email character varying(100),
    telepon character varying(20),
    jam_operasional character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: COLUMN kecamatans.kode_kecamatan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.kecamatans.kode_kecamatan IS 'Kode unik kecamatan (misal: KEC-001)';


--
-- Name: COLUMN kecamatans.nama_kecamatan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.kecamatans.nama_kecamatan IS 'Nama lengkap kecamatan';


--
-- Name: COLUMN kecamatans.alamat_kantor; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.kecamatans.alamat_kantor IS 'Alamat kantor kecamatan';


--
-- Name: COLUMN kecamatans.email; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.kecamatans.email IS 'Email resmi kecamatan';


--
-- Name: COLUMN kecamatans.telepon; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.kecamatans.telepon IS 'Nomor telepon kantor';


--
-- Name: COLUMN kecamatans.jam_operasional; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.kecamatans.jam_operasional IS 'Misal: Senin-Jumat, 08.00-16.00 WIB';


--
-- Name: kecamatans_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.kecamatans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: kecamatans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.kecamatans_id_seq OWNED BY public.kecamatans.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: service_requirements; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.service_requirements (
    id bigint NOT NULL,
    service_id bigint NOT NULL,
    nama_persyaratan character varying(150) NOT NULL,
    deskripsi text,
    is_required boolean DEFAULT true NOT NULL,
    urutan smallint DEFAULT '0'::smallint NOT NULL,
    accepted_formats json,
    max_size_kb integer DEFAULT 5120 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: COLUMN service_requirements.nama_persyaratan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.service_requirements.nama_persyaratan IS 'Nama dokumen persyaratan';


--
-- Name: COLUMN service_requirements.deskripsi; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.service_requirements.deskripsi IS 'Panduan dokumen (format, ukuran, dll.)';


--
-- Name: COLUMN service_requirements.is_required; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.service_requirements.is_required IS 'Wajib diunggah atau opsional';


--
-- Name: COLUMN service_requirements.urutan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.service_requirements.urutan IS 'Urutan tampil di checklist';


--
-- Name: COLUMN service_requirements.accepted_formats; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.service_requirements.accepted_formats IS 'Format file yang diterima (JSON array: ["pdf","jpg","png"])';


--
-- Name: COLUMN service_requirements.max_size_kb; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.service_requirements.max_size_kb IS 'Ukuran file maksimum dalam KB';


--
-- Name: service_requirements_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.service_requirements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: service_requirements_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.service_requirements_id_seq OWNED BY public.service_requirements.id;


--
-- Name: services; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.services (
    id bigint NOT NULL,
    kode_layanan character varying(20) NOT NULL,
    nama_layanan character varying(150) NOT NULL,
    deskripsi text,
    jenis_proses character varying(255) NOT NULL,
    template_formulir_path character varying(255),
    ikon character varying(50),
    is_active boolean DEFAULT true NOT NULL,
    urutan smallint DEFAULT '0'::smallint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    requires_desa_approval boolean DEFAULT false NOT NULL,
    CONSTRAINT services_jenis_proses_check CHECK (((jenis_proses)::text = ANY ((ARRAY['full_digital'::character varying, 'hybrid'::character varying])::text[])))
);


--
-- Name: COLUMN services.kode_layanan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.kode_layanan IS 'Kode unik layanan (misal: KIA, EKTP)';


--
-- Name: COLUMN services.nama_layanan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.nama_layanan IS 'Nama lengkap layanan';


--
-- Name: COLUMN services.deskripsi; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.deskripsi IS 'Deskripsi dan panduan layanan';


--
-- Name: COLUMN services.jenis_proses; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.jenis_proses IS 'Jenis alur proses: full_digital | hybrid';


--
-- Name: COLUMN services.template_formulir_path; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.template_formulir_path IS 'Path file template formulir (PDF) untuk diunduh warga';


--
-- Name: COLUMN services.ikon; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.ikon IS 'Nama ikon untuk UI (misal: identification)';


--
-- Name: COLUMN services.is_active; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.is_active IS 'Status aktif layanan';


--
-- Name: COLUMN services.urutan; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.urutan IS 'Urutan tampil di halaman layanan';


--
-- Name: COLUMN services.requires_desa_approval; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.services.requires_desa_approval IS 'Apakah pengajuan layanan ini wajib melewati verifikasi administrasi desa';


--
-- Name: services_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.services_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: services_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.services_id_seq OWNED BY public.services.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: submission_documents; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.submission_documents (
    id bigint NOT NULL,
    submission_id bigint NOT NULL,
    service_requirement_id bigint NOT NULL,
    file_path character varying(255) NOT NULL,
    file_name character varying(255),
    file_size bigint,
    mime_type character varying(100),
    status_validasi character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    catatan_dokumen text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT submission_documents_status_validasi_check CHECK (((status_validasi)::text = ANY ((ARRAY['pending'::character varying, 'valid'::character varying, 'invalid'::character varying])::text[])))
);


--
-- Name: COLUMN submission_documents.file_path; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submission_documents.file_path IS 'Lokasi penyimpanan file di disk storage';


--
-- Name: COLUMN submission_documents.file_name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submission_documents.file_name IS 'Nama asli berkas';


--
-- Name: COLUMN submission_documents.file_size; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submission_documents.file_size IS 'Ukuran file dalam bytes';


--
-- Name: COLUMN submission_documents.mime_type; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submission_documents.mime_type IS 'Tipe MIME berkas';


--
-- Name: COLUMN submission_documents.status_validasi; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submission_documents.status_validasi IS 'Status verifikasi berkas: pending | valid | invalid';


--
-- Name: COLUMN submission_documents.catatan_dokumen; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submission_documents.catatan_dokumen IS 'Catatan petugas jika berkas tidak sesuai/buram';


--
-- Name: submission_documents_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.submission_documents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: submission_documents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.submission_documents_id_seq OWNED BY public.submission_documents.id;


--
-- Name: submissions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.submissions (
    id bigint NOT NULL,
    nomor_tiket character varying(30) NOT NULL,
    user_id bigint NOT NULL,
    kecamatan_id bigint NOT NULL,
    service_id bigint NOT NULL,
    status character varying(50) DEFAULT 'draft'::character varying NOT NULL,
    catatan_petugas text,
    jadwal_biometrik timestamp(0) without time zone,
    nomor_antrean character varying(10),
    output_document_path character varying(255),
    form_data json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    desa_id bigint,
    verified_by_desa_id bigint,
    verified_desa_at timestamp(0) without time zone,
    catatan_desa text
);


--
-- Name: COLUMN submissions.nomor_tiket; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.nomor_tiket IS 'Nomor tiket unik (TKT-YYYYMMDD-KEC-XXXX)';


--
-- Name: COLUMN submissions.status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.status IS 'Status alur pengajuan';


--
-- Name: COLUMN submissions.catatan_petugas; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.catatan_petugas IS 'Catatan/instruksi dari petugas (revisi/penolakan)';


--
-- Name: COLUMN submissions.jadwal_biometrik; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.jadwal_biometrik IS 'Jadwal rekam biometrik e-KTP (khusus layanan EKTP)';


--
-- Name: COLUMN submissions.nomor_antrean; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.nomor_antrean IS 'Nomor antrean rekam biometrik';


--
-- Name: COLUMN submissions.output_document_path; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.output_document_path IS 'Path file e-dokumen hasil yang bisa diunduh warga';


--
-- Name: COLUMN submissions.form_data; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.form_data IS 'Data formulir tambahan (JSON) per jenis layanan';


--
-- Name: COLUMN submissions.verified_desa_at; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.verified_desa_at IS 'Waktu verifikasi oleh pihak desa';


--
-- Name: COLUMN submissions.catatan_desa; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.submissions.catatan_desa IS 'Catatan atau pengantar dari Kasi Pelayanan Desa';


--
-- Name: submissions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.submissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: submissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.submissions_id_seq OWNED BY public.submissions.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    nik character varying(16),
    phone character varying(20),
    role character varying(50) DEFAULT 'warga'::character varying NOT NULL,
    kecamatan_id bigint,
    desa_id bigint,
    alamat_detail text
);


--
-- Name: COLUMN users.nik; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.users.nik IS 'Nomor Induk Kependudukan 16 digit';


--
-- Name: COLUMN users.phone; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.users.phone IS 'Nomor telepon aktif';


--
-- Name: COLUMN users.role; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.users.role IS 'Role: warga | admin_kecamatan | super_admin';


--
-- Name: COLUMN users.alamat_detail; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.users.alamat_detail IS 'Alamat lengkap: RT/RW, nama jalan, dll';


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: desas id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.desas ALTER COLUMN id SET DEFAULT nextval('public.desas_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: kecamatans id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.kecamatans ALTER COLUMN id SET DEFAULT nextval('public.kecamatans_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: service_requirements id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.service_requirements ALTER COLUMN id SET DEFAULT nextval('public.service_requirements_id_seq'::regclass);


--
-- Name: services id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.services ALTER COLUMN id SET DEFAULT nextval('public.services_id_seq'::regclass);


--
-- Name: submission_documents id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submission_documents ALTER COLUMN id SET DEFAULT nextval('public.submission_documents_id_seq'::regclass);


--
-- Name: submissions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions ALTER COLUMN id SET DEFAULT nextval('public.submissions_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: desas; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.desas (id, kecamatan_id, kode_desa, nama_desa, created_at, updated_at) FROM stdin;
1	17	3206170001	Manonjaya	2026-08-27 06:04:07	2026-08-27 06:04:07
2	17	3206170002	Kalimanggis	2026-08-27 06:04:07	2026-08-27 06:04:07
3	17	3206170003	Pasirbatang	2026-08-27 06:04:07	2026-08-27 06:04:07
4	17	3206170004	Kamulyan	2026-08-27 06:04:07	2026-08-27 06:04:07
5	17	3206170005	Margaluyu	2026-08-27 06:04:07	2026-08-27 06:04:07
6	17	3206170006	Cibeber	2026-08-27 06:04:07	2026-08-27 06:04:07
7	17	3206170007	Sukaratu	2026-08-27 06:04:07	2026-08-27 06:04:07
8	17	3206170008	Cihaur	2026-08-27 06:04:07	2026-08-27 06:04:07
9	17	3206170009	Pasirhuni	2026-08-27 06:04:07	2026-08-27 06:04:07
10	17	3206170010	Gunungtanjung	2026-08-27 06:04:07	2026-08-27 06:04:07
11	17	3206170011	Bantar	2026-08-27 06:04:07	2026-08-27 06:04:07
12	17	3206170012	Margahayu	2026-08-27 06:04:07	2026-08-27 06:04:07
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: kecamatans; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.kecamatans (id, kode_kecamatan, nama_kecamatan, alamat_kantor, email, telepon, jam_operasional, created_at, updated_at) FROM stdin;
1	KEC-001	Kadipaten	Jl. Raya Kadipaten No. 1, Kab. Tasikmalaya	kec.kadipaten@tasikmalayakab.go.id	0265-420001	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
2	KEC-002	Pagerageung	Jl. Raya Pagerageung No. 1, Kab. Tasikmalaya	kec.pagerageung@tasikmalayakab.go.id	0265-420002	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
3	KEC-003	Ciawi	Jl. Raya Ciawi No. 1, Kab. Tasikmalaya	kec.ciawi@tasikmalayakab.go.id	0265-420003	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
4	KEC-004	Sukaresik	Jl. Raya Sukaresik No. 1, Kab. Tasikmalaya	kec.sukaresik@tasikmalayakab.go.id	0265-420004	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
5	KEC-005	Jamanis	Jl. Raya Jamanis No. 1, Kab. Tasikmalaya	kec.jamanis@tasikmalayakab.go.id	0265-420005	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
6	KEC-006	Sukahening	Jl. Raya Sukahening No. 1, Kab. Tasikmalaya	kec.sukahening@tasikmalayakab.go.id	0265-420006	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
7	KEC-007	Rajapolah	Jl. Raya Rajapolah No. 1, Kab. Tasikmalaya	kec.rajapolah@tasikmalayakab.go.id	0265-420007	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
8	KEC-008	Cisayong	Jl. Raya Cisayong No. 1, Kab. Tasikmalaya	kec.cisayong@tasikmalayakab.go.id	0265-420008	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
9	KEC-009	Sariwangi	Jl. Raya Sariwangi No. 1, Kab. Tasikmalaya	kec.sariwangi@tasikmalayakab.go.id	0265-420009	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
10	KEC-010	Leuwisari	Jl. Raya Leuwisari No. 1, Kab. Tasikmalaya	kec.leuwisari@tasikmalayakab.go.id	0265-420010	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
11	KEC-011	Padakembang	Jl. Raya Padakembang No. 1, Kab. Tasikmalaya	kec.padakembang@tasikmalayakab.go.id	0265-420011	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
12	KEC-012	Sukaratul	Jl. Raya Sukaratul No. 1, Kab. Tasikmalaya	kec.sukaratu@tasikmalayakab.go.id	0265-420012	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
13	KEC-013	Singaparna	Jl. Raya Singaparna No. 1, Kab. Tasikmalaya	kec.singaparna@tasikmalayakab.go.id	0265-420013	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
14	KEC-014	Salawu	Jl. Raya Salawu No. 1, Kab. Tasikmalaya	kec.salawu@tasikmalayakab.go.id	0265-420014	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
15	KEC-015	Mangunreja	Jl. Raya Mangunreja No. 1, Kab. Tasikmalaya	kec.mangunreja@tasikmalayakab.go.id	0265-420015	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
16	KEC-016	Sukarame	Jl. Raya Sukarame No. 1, Kab. Tasikmalaya	kec.sukarame@tasikmalayakab.go.id	0265-420016	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
17	KEC-017	Manonjaya	Jl. Kaum No. 12, Manonjaya, Tasikmalaya	kec.manonjaya@tasikmalayakab.go.id	0265-380123	Senin - Jumat, 08.00 - 16.00 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
18	KEC-018	Cineam	Jl. Raya Cineam No. 1, Kab. Tasikmalaya	kec.cineam@tasikmalayakab.go.id	0265-420018	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
19	KEC-019	Taraju	Jl. Raya Taraju No. 1, Kab. Tasikmalaya	kec.taraju@tasikmalayakab.go.id	0265-420019	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
20	KEC-020	Puspahiang	Jl. Raya Puspahiang No. 1, Kab. Tasikmalaya	kec.puspahiang@tasikmalayakab.go.id	0265-420020	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
21	KEC-021	Tanjungjaya	Jl. Raya Tanjungjaya No. 1, Kab. Tasikmalaya	kec.tanjungjaya@tasikmalayakab.go.id	0265-420021	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
22	KEC-022	Sukaraja	Jl. Raya Sukaraja No. 1, Kab. Tasikmalaya	kec.sukaraja@tasikmalayakab.go.id	0265-420022	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
23	KEC-023	Gunungtanjung	Jl. Raya Gunungtanjung No. 1, Kab. Tasikmalaya	kec.gunungtanjung@tasikmalayakab.go.id	0265-420023	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
24	KEC-024	Karangjaya	Jl. Raya Karangjaya No. 1, Kab. Tasikmalaya	kec.karangjaya@tasikmalayakab.go.id	0265-420024	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
25	KEC-025	Bojongasih	Jl. Raya Bojongasih No. 1, Kab. Tasikmalaya	kec.bojongasih@tasikmalayakab.go.id	0265-420025	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
26	KEC-026	Parungponteng	Jl. Raya Parungponteng No. 1, Kab. Tasikmalaya	kec.parungponteng@tasikmalayakab.go.id	0265-420026	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
27	KEC-027	Bantarkalong	Jl. Raya Bantarkalong No. 1, Kab. Tasikmalaya	kec.bantarkalong@tasikmalayakab.go.id	0265-420027	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
28	KEC-028	Culamega	Jl. Raya Culamega No. 1, Kab. Tasikmalaya	kec.culamega@tasikmalayakab.go.id	0265-420028	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
29	KEC-029	Bojonggambir	Jl. Raya Bojonggambir No. 1, Kab. Tasikmalaya	kec.bojonggambir@tasikmalayakab.go.id	0265-420029	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
30	KEC-030	Sodonghilir	Jl. Raya Sodonghilir No. 1, Kab. Tasikmalaya	kec.sodonghilir@tasikmalayakab.go.id	0265-420030	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
31	KEC-031	Cikatomas	Jl. Raya Cikatomas No. 1, Kab. Tasikmalaya	kec.cikatomas@tasikmalayakab.go.id	0265-420031	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
32	KEC-032	Cibalong	Jl. Raya Cibalong No. 1, Kab. Tasikmalaya	kec.cibalong@tasikmalayakab.go.id	0265-420032	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
33	KEC-033	Cipatujah	Jl. Raya Cipatujah No. 1, Kab. Tasikmalaya	kec.cipatujah@tasikmalayakab.go.id	0265-420033	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
34	KEC-034	Karangnunggal	Jl. Raya Karangnunggal No. 1, Kab. Tasikmalaya	kec.karangnunggal@tasikmalayakab.go.id	0265-420034	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
35	KEC-035	Cikalong	Jl. Raya Cikalong No. 1, Kab. Tasikmalaya	kec.cikalong@tasikmalayakab.go.id	0265-420035	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
36	KEC-036	Pancatengah	Jl. Raya Pancatengah No. 1, Kab. Tasikmalaya	kec.pancatengah@tasikmalayakab.go.id	0265-420036	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
37	KEC-037	Jatiwaras	Jl. Raya Jatiwaras No. 1, Kab. Tasikmalaya	kec.jatiwaras@tasikmalayakab.go.id	0265-420037	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
38	KEC-038	Cigalontang	Jl. Raya Cigalontang No. 1, Kab. Tasikmalaya	kec.cigalontang@tasikmalayakab.go.id	0265-420038	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
39	KEC-039	Cipatujah Selatan	Jl. Raya Cipatujah Selatan No. 1, Kab. Tasikmalaya	kec.cipatujahselatan@tasikmalayakab.go.id	0265-420039	Senin - Jumat, 08.00 - 15.30 WIB	2026-08-27 06:04:07	2026-08-27 06:04:07
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_08_27_034055_add_role_to_users_table	1
5	2026_08_27_060000_create_kecamatans_table	1
6	2026_08_27_060001_create_desas_table	1
7	2026_08_27_060002_update_users_table_for_portal	1
8	2026_08_27_060003_create_services_table	1
9	2026_08_27_060004_create_service_requirements_table	1
10	2026_08_27_060005_create_submissions_table	1
11	2026_08_27_060006_create_submission_documents_table	1
12	2026_09_04_000001_add_desa_workflow_to_tables	2
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: service_requirements; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.service_requirements (id, service_id, nama_persyaratan, deskripsi, is_required, urutan, accepted_formats, max_size_kb, created_at, updated_at) FROM stdin;
1	1	Kartu Keluarga (KK)	Scan/Foto Kartu Keluarga orang tua yang masih berlaku (asli)	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
2	1	Akta Kelahiran Anak	Scan/Foto Akta Kelahiran anak yang diajukan	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
3	1	KTP Elektronik Orang Tua	Scan/Foto e-KTP kedua orang tua/wali	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
4	1	Pas Foto Anak (Usia > 5 Tahun)	Pas foto ukuran 3x4 latar belakang merah/biru (khusus anak usia di atas 5 tahun)	f	4	["jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
5	2	Kartu Keluarga (KK)	Scan/Foto asli Kartu Keluarga yang mencantumkan nama pemohon	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
6	2	Surat Pengantar RT/RW (Jika Diperlukan)	Scan surat pengantar dari RT/RW setempat (opsional jika sudah terdaftar di database)	f	2	["pdf","jpg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
7	3	Formulir F-1.01 Desa	Unduh template, bawa ke Desa untuk ditandatangani dan dicap, lalu unggah kembali scan aslinya	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
8	3	Buku Nikah / Kutipan Akta Perkawinan	Scan Buku Nikah / Akta Perkawinan resmi dari KUA / Catatan Sipil	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
9	3	KK Asli Masing-masing Orang Tua	Scan Kartu Keluarga orang tua dari kedua belah pihak	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
10	3	KTP Elektronik Pasangan	Scan e-KTP suami dan istri	t	4	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
11	4	Kartu Keluarga (KK) Lama	Scan/Foto Kartu Keluarga lama yang akan diperbarui	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
12	4	Surat Keterangan Kelahiran / Akta Lahir	Scan Surat Kelahiran dari Bidan/RS atau Akta Kelahiran anggota baru	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
13	4	Buku Nikah Orang Tua	Scan Buku Nikah legalisir atau asli	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
14	5	Kartu Keluarga (KK) Lama	Scan Kartu Keluarga lama yang masih mencantumkan anggota yang bersangkutan	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
15	5	Surat Kematian / Akta Cerai	Scan Surat Kematian dari Desa/RS (jika meninggal) ATAU Akta Cerai dari Pengadilan Agama (jika cerai)	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
16	5	e-KTP Pemohon	Scan e-KTP kepala keluarga / pemohon	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
17	6	Formulir Permohonan Pindah Desa (F-1.08)	Unduh formulir, tandatangani di kantor Desa asal, lalu unggah hasil scan bertanda tangan & stempel basah	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
18	6	Kartu Keluarga Asli	Scan Kartu Keluarga asal	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
19	6	e-KTP Pemohon & Anggota yang Pindah	Scan e-KTP seluruh anggota keluarga yang ikut pindah domisili	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
20	6	Pas Foto Ukuran 3x4 (2 Lembar)	Foto berwarna terbaru dengan latar belakang merah atau biru	t	4	["jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
21	7	Formulir N1 - N4 dari Desa	Unduh form N1-N4, lengkapi tanda tangan dan stempel Kepala Desa/Kelurahan setempat	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
22	7	Surat Pengantar / Rekomendasi KUA Asal	Scan surat pengantar resmi dari Kantor Urusan Agama (KUA) kecamatan domisili	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
23	7	e-KTP Calon Pengantin & Orang Tua	Scan e-KTP kedua calon pengantin dan orang tua/wali	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
24	7	Kartu Keluarga (KK)	Scan Kartu Keluarga calon pengantin	t	4	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
25	7	Pas Foto Berdampingan 4x6 (Latar Biru)	Foto berdampingan calon pengantin berlatar belakang biru	t	5	["jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
26	8	Surat Pengantar dari Desa / Kelurahan	Scan surat pengantar resmi dari Kantor Desa mengenai perihal surat yang dibutuhkan	t	1	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
27	8	Kartu Tanda Penduduk (e-KTP)	Scan/Foto e-KTP pemohon yang masih berlaku	t	2	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
28	8	Kartu Keluarga (KK)	Scan Kartu Keluarga pemohon	t	3	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
29	8	Dokumen Pendukung Tambahan	Scan dokumen pendukung sesuai jenis surat (ijazah, sertifikat, dll.)	f	4	["pdf","jpg","jpeg","png"]	5120	2026-08-27 06:04:07	2026-08-27 06:04:07
30	9	Surat Pindah dari Kecamatan Asal	Unggah scan/foto Surat Keterangan Pindah (SKPWNI) dari kecamatan asal	t	1	["pdf","jpg","jpeg","png"]	5120	2026-09-03 04:46:46	2026-09-03 04:46:46
31	9	Kartu Keluarga Asli	Scan/foto asli Kartu Keluarga (KK)	t	2	["pdf","jpg","jpeg","png"]	5120	2026-09-03 04:46:46	2026-09-03 04:46:46
32	9	E-KTP Pemohon	Scan/foto Kartu Tanda Penduduk Elektronik (e-KTP) pemohon	t	3	["pdf","jpg","jpeg","png"]	5120	2026-09-03 04:46:46	2026-09-03 04:46:46
\.


--
-- Data for Name: services; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.services (id, kode_layanan, nama_layanan, deskripsi, jenis_proses, template_formulir_path, ikon, is_active, urutan, created_at, updated_at, requires_desa_approval) FROM stdin;
1	KIA	Pembuatan Kartu Identitas Anak (KIA)	Pengajuan penerbitan Kartu Identitas Anak untuk anak usia 0-17 tahun kurang satu hari yang belum menikah.	full_digital	\N	identification	t	1	2026-08-27 06:04:07	2026-08-27 06:04:07	f
2	EKTP	Perekaman E-KTP (KTP Elektronik)	Pendaftaran online dan booking jadwal antrean perekaman data biometrik (sidik jari, iris mata, foto) di kantor kecamatan.	hybrid	\N	fingerprint	t	2	2026-08-27 06:04:07	2026-08-27 06:04:07	f
4	KK_ADD	Perbaikan KK - Penambahan Anggota Keluarga	Pengajuan penambahan anggota keluarga pada KK yang sudah ada (kelahiran anak, kepindahan masuk, dll.).	full_digital	\N	user-plus	t	4	2026-08-27 06:04:07	2026-08-27 06:04:07	f
5	KK_DEL	Perbaikan KK - Pengurangan Anggota Keluarga	Pengajuan pengurangan anggota keluarga pada Kartu Keluarga karena alasan meninggal dunia atau perceraian.	full_digital	\N	user-minus	t	5	2026-08-27 06:04:07	2026-08-27 06:04:07	f
9	DATANG	Surat Datang Antar Kecamatan	Pengajuan Surat Keterangan Datang bagi warga yang pindah domisili masuk antar kecamatan dalam Kabupaten Tasikmalaya.	hybrid	\N	inbox	t	7	2026-09-03 04:46:46	2026-09-03 04:46:46	f
3	KK_BARU	Pembuatan Kartu Keluarga (KK) Baru	Pengajuan penerbitan Kartu Keluarga baru untuk pasangan yang baru menikah atau pembentukan keluarga baru.	hybrid	templates/f101_permohonan_kk_baru.pdf	users	t	3	2026-08-27 06:04:07	2026-09-04 08:45:42	t
6	PINDAH	Surat Pindah Antar Kecamatan (SKPWNI)	Pengajuan Surat Keterangan Pindah Warga Negara Indonesia (SKPWNI) antar wilayah kecamatan dalam Kabupaten Tasikmalaya.	hybrid	templates/f108_surat_pindah.pdf	truck	t	6	2026-08-27 06:04:07	2026-09-04 08:45:42	t
7	NIKAH	Surat Dispensasi / Rekomendasi Nikah	Pengajuan Surat Rekomendasi/Dispensasi Pernikahan bagi warga yang akan melangsungkan akad di luar kecamatan atau waktu mendesak.	hybrid	templates/n1_n4_rekomendasi_nikah.pdf	heart	t	8	2026-08-27 06:04:07	2026-09-04 08:45:42	t
8	LAINNYA	Surat Keterangan Umum & Administrasi Lainnya	Pengajuan berbagai surat keterangan umum dari kecamatan (keterangan belum menikah, keterangan beda nama, dll.) secara fleksibel.	full_digital	\N	document-text	t	9	2026-08-27 06:04:07	2026-09-04 08:45:42	t
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
F2E5J4QXFXI4AbuTd7BeWxiG06lXSalXt6FA7c2j	\N	127.0.0.1	Go-http-client/1.1	eyJfdG9rZW4iOiJTS0Q5WlNLMmV5bUppaFl4TDF2ZDJRMVNFUzkydTJqZDhhQWxkT1R2IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==	1788511690
QEusZVI2urp1TO2YE6aE6bCoZeZYa9qeFltRxqZM	\N	127.0.0.1	Go-http-client/1.1	eyJfdG9rZW4iOiJNOHY1UGNydGk1cHVINktINGR6MHhwcnNVNjZuOFBTbmRnbExEZ0tqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==	1788511690
8MEl8Eclv7c0rQhvP97RqVeba5g4sSX7InOELprl	3	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJUZHFmQUprcUpPTU9IMkY3cEFMYmlhUjNIU3N5NGZlMjdNZHNUYnpZIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3dhcmdhXC9wZXJtb2hvbmFuXC9idWF0P3NlcnZpY2U9S0tfQkFSVSIsInJvdXRlIjoid2FyZ2Euc3VibWlzc2lvbnMuY3JlYXRlIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjozfQ==	1788516418
3DH5PZbv3kAbPYoXRY9wcgBK3YD80zJQfCPYyoZZ	3	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJ6dVNYc2JqNG9DbmtMNmNlQXpTa1AwdU9ab2NOWjdlc0JETTh3anQ2IiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3dhcmdhXC9wZXJtb2hvbmFuXC8xXC9jZXRhay1mMTAxIiwicm91dGUiOiJ3YXJnYS5zdWJtaXNzaW9ucy5wcmludC1mMTAxIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjozfQ==	1788516776
\.


--
-- Data for Name: submission_documents; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.submission_documents (id, submission_id, service_requirement_id, file_path, file_name, file_size, mime_type, status_validasi, catatan_dokumen, created_at, updated_at) FROM stdin;
1	1	5	submissions/1/documents/5_laporan-keuangan-rumah-laundry_kNKwb3FD.pdf	Laporan Keuangan — Rumah Laundry.pdf	187751	application/pdf	pending	\N	2026-09-02 13:40:24	2026-09-02 13:40:24
2	2	1	submissions/2/documents/1_picture1_8M2RdM6J.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 04:24:03	2026-09-03 04:24:03
3	2	2	submissions/2/documents/2_picture1_NjLeCRat.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 04:24:03	2026-09-03 04:24:03
4	2	3	submissions/2/documents/3_picture1_iqsgnxmh.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 04:24:03	2026-09-03 04:24:03
5	2	4	submissions/2/documents/4_picture1_86cO4ZCh.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 04:24:03	2026-09-03 04:24:03
6	3	30	documents/sample_30.pdf	Surat Pindah dari Kecamatan Asal.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
7	3	31	documents/sample_31.pdf	Kartu Keluarga Asli.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
8	3	32	documents/sample_32.pdf	E-KTP Pemohon.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
9	4	1	documents/sample_1.pdf	Kartu Keluarga (KK).pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 05:04:00	2026-09-03 05:04:00
10	4	2	documents/sample_2.pdf	Akta Kelahiran Anak.pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 05:04:00	2026-09-03 05:04:00
11	4	3	documents/sample_3.pdf	KTP Elektronik Orang Tua.pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 05:04:00	2026-09-03 05:04:00
12	4	4	documents/sample_4.pdf	Pas Foto Anak (Usia > 5 Tahun).pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 05:04:00	2026-09-03 05:04:00
13	5	7	documents/sample_7.pdf	Formulir F-1.01 Desa.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
14	5	8	documents/sample_8.pdf	Buku Nikah / Kutipan Akta Perkawinan.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
15	5	9	documents/sample_9.pdf	KK Asli Masing-masing Orang Tua.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
16	5	10	documents/sample_10.pdf	KTP Elektronik Pasangan.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
17	6	7	documents/sample_7.pdf	Formulir F-1.01 Desa.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
18	6	8	documents/sample_8.pdf	Buku Nikah / Kutipan Akta Perkawinan.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
19	6	9	documents/sample_9.pdf	KK Asli Masing-masing Orang Tua.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
20	6	10	documents/sample_10.pdf	KTP Elektronik Pasangan.pdf	524288	application/pdf	valid	\N	2026-09-03 05:04:00	2026-09-03 05:04:00
40	13	8	submissions/13/documents/8_diskominfo-logo_yVjJ8U9O.jpg	diskominfo_logo.jpg	9073	image/jpeg	pending	\N	2026-09-03 06:44:36	2026-09-03 06:44:36
22	7	31	submissions/7/documents/31_picture1_lZw8Ds9j.png	Picture1.png	31286	image/png	pending	-	2026-09-03 05:08:22	2026-09-03 05:09:48
23	7	32	submissions/7/documents/32_picture1_OFgQiaqZ.png	Picture1.png	31286	image/png	pending	-	2026-09-03 05:08:22	2026-09-03 05:09:48
21	7	30	submissions/7/documents/30_picture1_BeaieTWS.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 05:08:22	2026-09-03 05:10:41
24	8	5	submissions/8/documents/5_picture1_fxnzqrLQ.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 05:13:29	2026-09-03 05:13:29
25	8	6	submissions/8/documents/6_picture1_tg6THh7g.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 05:13:29	2026-09-03 05:13:29
26	9	8	submissions/9/documents/8_picture1_WbG0jXNq.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 05:56:22	2026-09-03 05:56:22
27	9	9	submissions/9/documents/9_picture1_ONDdCO6u.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 05:56:22	2026-09-03 05:56:22
28	9	10	submissions/9/documents/10_picture1_R3gXRwyy.png	Picture1.png	31286	image/png	pending	\N	2026-09-03 05:56:22	2026-09-03 05:56:22
29	10	30	documents/sample_30.pdf	Surat Pindah dari Kecamatan Asal.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
30	10	31	documents/sample_31.pdf	Kartu Keluarga Asli.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
31	10	32	documents/sample_32.pdf	E-KTP Pemohon.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
32	11	1	documents/sample_1.pdf	Kartu Keluarga (KK).pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 06:02:09	2026-09-03 06:02:09
33	11	2	documents/sample_2.pdf	Akta Kelahiran Anak.pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 06:02:09	2026-09-03 06:02:09
34	11	3	documents/sample_3.pdf	KTP Elektronik Orang Tua.pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 06:02:09	2026-09-03 06:02:09
35	11	4	documents/sample_4.pdf	Pas Foto Anak (Usia > 5 Tahun).pdf	524288	application/pdf	invalid	Dokumen buram, harap perbaiki	2026-09-03 06:02:09	2026-09-03 06:02:09
36	12	7	documents/sample_7.pdf	Formulir F-1.01 Desa.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
37	12	8	documents/sample_8.pdf	Buku Nikah / Kutipan Akta Perkawinan.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
38	12	9	documents/sample_9.pdf	KK Asli Masing-masing Orang Tua.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
39	12	10	documents/sample_10.pdf	KTP Elektronik Pasangan.pdf	524288	application/pdf	valid	\N	2026-09-03 06:02:09	2026-09-03 06:02:09
41	13	9	submissions/13/documents/9_logopkk_cV4ciAga.png	logoPKK.png	709624	image/png	pending	\N	2026-09-03 06:44:36	2026-09-03 06:44:36
42	13	10	submissions/13/documents/10_logo-atau-lambang-pkk_NvQg9A8f.png	logo-atau-lambang-pkk.png	637500	image/png	pending	\N	2026-09-03 06:44:36	2026-09-03 06:44:36
43	14	8	submissions/14/documents/8_picture1_XjQ8keOf.jpg	Picture1.jpg	84730	image/jpeg	pending	\N	2026-09-04 08:58:40	2026-09-04 08:58:40
44	14	9	submissions/14/documents/9_picture1_CONfwBHm.jpg	Picture1.jpg	84730	image/jpeg	pending	\N	2026-09-04 08:58:40	2026-09-04 08:58:40
45	14	10	submissions/14/documents/10_picture1_ycphQG5u.jpg	Picture1.jpg	84730	image/jpeg	pending	\N	2026-09-04 08:58:40	2026-09-04 08:58:40
\.


--
-- Data for Name: submissions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.submissions (id, nomor_tiket, user_id, kecamatan_id, service_id, status, catatan_petugas, jadwal_biometrik, nomor_antrean, output_document_path, form_data, created_at, updated_at, desa_id, verified_by_desa_id, verified_desa_at, catatan_desa) FROM stdin;
5	TKT-20260831-17-0403	4	17	3	completed	Permohonan telah diverifikasi dan disetujui. Dokumen resmi telah diterbitkan secara digital.	\N	\N	outputs/dokumen_terbit_TKT-20260831-17-0403.pdf	\N	2026-08-31 05:04:00	2026-09-02 05:04:00	\N	\N	\N	\N
4	TKT-20260903-17-0402	4	17	1	revision_required	Scan/Foto Kartu Keluarga yang diunggah buram dan terpotong pada bagian tanda tangan kepala dinas. Mohon unggah ulang foto asli dokumen dengan jelas.	\N	\N	\N	\N	2026-09-02 05:04:00	2026-09-03 03:04:00	\N	\N	\N	\N
3	TKT-20260903-17-0401	4	17	9	submitted	Berkas telah diterima sistem dan masuk dalam antrean verifikasi petugas.	\N	\N	\N	\N	2026-09-03 01:04:00	2026-09-03 01:04:00	\N	\N	\N	\N
11	TKT-20260903-17-0502	5	17	1	revision_required	Scan/Foto Kartu Keluarga yang diunggah buram dan terpotong pada bagian tanda tangan kepala dinas. Mohon unggah ulang foto asli dokumen dengan jelas.	\N	\N	\N	\N	2026-09-02 06:02:09	2026-09-03 04:02:09	\N	\N	\N	\N
10	TKT-20260903-17-0501	5	17	9	submitted	Berkas telah diterima sistem dan masuk dalam antrean verifikasi petugas.	\N	\N	\N	\N	2026-09-03 02:02:09	2026-09-03 02:02:09	\N	\N	\N	\N
6	TKT-20260831-17-0303	3	17	3	completed	Permohonan telah diverifikasi dan disetujui. Dokumen resmi telah diterbitkan secara digital.	\N	\N	outputs/dokumen_terbit_TKT-20260831-17-0303.pdf	\N	2026-08-31 05:04:00	2026-09-02 05:04:00	1	\N	\N	\N
8	TKT-20260903-17-0404	3	17	2	submitted_desa	Jadwal rekam biometrik e-KTP ditetapkan pada Tuesday, 8 September 2026 - 13:15 WIB di Kantor Kecamatan Manonjaya. Nomor antrean Anda: 01.	2026-09-08 13:15:00	01	\N	\N	2026-09-03 05:13:29	2026-09-03 05:14:40	1	\N	\N	\N
13	TKT-20260903-17-0503	5	17	3	completed	Permohonan telah selesai diproses. Anda dapat mengunduh dokumen hasil atau mengambil berkas fisik di kantor kecamatan.	\N	\N	submissions/13/output/e_dokumen_hasil_dcCOfTPk.pdf	{"f101":{"jenis_pilihan":"wni","nama_kepala_keluarga":"nabillah fridayesi","nik_kepala_keluarga":"320623010102004","telepon":"085858863254","alamat":"nanggorak","rt":"002","rw":"002","kode_pos":"46182","email":"nabilah20@gmail.com","jumlah_anggota":"2","nama_provinsi":"32 - JAWA BARAT","nama_kabupaten":"06 - KAB. TASIKMALAYA","nama_kecamatan":"Manonjaya","nama_desa":"kalimanggis","nama_dusun":"nanggorak","anggota":[{"nama":"nabillah fridayesi","nik":"320623010102004","jenis_kelamin":"P","tempat_lahir":"Tasikmalaya","tanggal_lahir":"2004-07-09","gol_darah":"-","agama":"Islam","shdk":"Kepala Keluarga","status_kawin":"Kawin Tercatat","pendidikan":"SLTA \\/ Sederajat","pekerjaan":"Mengurus Rumah Tangga","no_akta_lahir":"12","nama_ibu":"yanti","nik_ibu":"320623010102004","nama_ayah":"yanto","nik_ayah":"3206230303020005","disabilitas":"Tidak Ada"},{"nama":"Rifa Fauzi","nik":"3206230808090009","jenis_kelamin":"L","tempat_lahir":"Tasikmalaya","tanggal_lahir":"2025-07-30","gol_darah":"-","agama":"Islam","shdk":"Anak","status_kawin":"Belum Kawin","pendidikan":"Tidak \\/ Belum Sekolah","pekerjaan":"Pelajar \\/ Mahasiswa","no_akta_lahir":"07","nama_ibu":"nabillah fridayesi","nik_ibu":"320623010102004","nama_ayah":"ikbal","nik_ayah":"320623010102010","disabilitas":"Tidak Ada"}]}}	2026-09-03 06:44:36	2026-09-03 06:45:53	\N	\N	\N	\N
12	TKT-20260831-17-0503	5	17	3	completed	Permohonan telah diverifikasi dan disetujui. Dokumen resmi telah diterbitkan secara digital.	\N	\N	outputs/dokumen_terbit_TKT-20260831-17-0503.pdf	{"f101":{"jenis_pilihan":"wni","nama_kepala_keluarga":"nabillah fridayesi","nik_kepala_keluarga":"3206171505980001","alamat":"Kp. Kaum Wetan RT 002 RW 004 No. 15","rt":"002","rw":"004","kode_pos":"46182","telepon":"085712345678","email":"nabilah20@gmail.com","nama_provinsi":"32 - JAWA BARAT","nama_kabupaten":"06 - KAB. TASIKMALAYA","nama_kecamatan":"MANONJAYA","nama_desa":"MANONJAYA","nama_dusun":"KP. KAUM WETAN","jumlah_anggota":3,"anggota":[{"nama":"nabillah fridayesi","nik":"3206171505980001","jenis_kelamin":"L","tempat_lahir":"Tasikmalaya","tanggal_lahir":"1998-05-15","gol_darah":"O","agama":"Islam","status_kawin":"Kawin Tercatat","shdk":"Kepala Keluarga","pendidikan":"Diploma IV \\/ Strata I","pekerjaan":"Karyawan Swasta","no_akta_lahir":"3206-LT-15051998-0021","no_buku_nikah":"0145\\/012\\/VI\\/2023","tgl_nikah":"2023-06-10","nama_ibu":"SITI AMINAH","nik_ibu":"3206174502700001","nama_ayah":"ABDUL RAHMAN","nik_ayah":"3206171203680001","disabilitas":"Tidak Ada"},{"nama":"NURUL HIDAYAH","nik":"3206175408990002","jenis_kelamin":"P","tempat_lahir":"Tasikmalaya","tanggal_lahir":"1999-08-14","gol_darah":"A","agama":"Islam","status_kawin":"Kawin Tercatat","shdk":"Istri","pendidikan":"SLTA \\/ Sederajat","pekerjaan":"Mengurus Rumah Tangga","no_akta_lahir":"3206-LT-14081999-0015","no_buku_nikah":"0145\\/012\\/VI\\/2023","tgl_nikah":"2023-06-10","nama_ibu":"ROHAYATI","nik_ibu":"3206176504720003","nama_ayah":"MAMAN SUPARMAN","nik_ayah":"3206170809690002","disabilitas":"Tidak Ada"},{"nama":"MUHAMMAD AL FATIH","nik":"3206171201240001","jenis_kelamin":"L","tempat_lahir":"Tasikmalaya","tanggal_lahir":"2024-01-12","gol_darah":"O","agama":"Islam","status_kawin":"Belum Kawin","shdk":"Anak","pendidikan":"Tidak \\/ Belum Sekolah","pekerjaan":"Belum \\/ Tidak Bekerja","no_akta_lahir":"3206-LT-12012024-0005","nama_ibu":"NURUL HIDAYAH","nik_ibu":"3206175408990002","nama_ayah":"nabillah fridayesi","nik_ayah":"3206171505980001","disabilitas":"Tidak Ada"}]}}	2026-08-31 06:02:09	2026-09-02 06:02:09	\N	\N	\N	\N
9	TKT-20260903-17-0405	3	17	3	completed	Permohonan telah selesai diproses. Anda dapat mengunduh dokumen hasil atau mengambil berkas fisik di kantor kecamatan.	\N	\N	submissions/9/output/e_dokumen_hasil_RGpixmtT.pdf	{"f101":{"jenis_pilihan":"wni","nama_kepala_keluarga":"fuji","nik_kepala_keluarga":"3206171505980001","telepon":"085712345678","alamat":"Kp. Kaum Wetan RT 02 \\/ RW 04 No. 15, Manonjaya","rt":"001","rw":"001","kode_pos":"46182","email":"warga@portal.test","jumlah_anggota":"1","nama_provinsi":"32 - JAWA BARAT","nama_kabupaten":"06 - KAB. TASIKMALAYA","nama_kecamatan":"Manonjaya","nama_desa":"Manonjaya","nama_dusun":"cisitukaler","anggota":[{"nama":"nabilah","nik":"3206171505980001","jenis_kelamin":"P","tempat_lahir":"Tasikmalaya","tanggal_lahir":"2026-09-03","gol_darah":"A","agama":"Islam","shdk":"Anak","status_kawin":"Belum Kawin","pendidikan":"Akademi \\/ Diploma III \\/ Sarjana Muda","pekerjaan":"Pelajar \\/ Mahasiswa","no_akta_lahir":"230202020","nama_ibu":"yanti","nik_ibu":"320622180601004","nama_ayah":"fuji","nik_ayah":"320622180601004","disabilitas":"Tidak Ada"}]}}	2026-09-03 05:56:22	2026-09-03 06:25:45	1	\N	\N	\N
7	TKT-20260903-17-0403	3	17	9	completed	Permohonan telah selesai diproses. Anda dapat mengunduh dokumen hasil atau mengambil berkas fisik di kantor kecamatan.	\N	\N	submissions/7/output/e_dokumen_hasil_wkDDqruf.pdf	\N	2026-09-03 05:08:22	2026-09-03 05:12:24	1	\N	\N	\N
2	TKT-20260903-17-0001	3	17	1	revision_required	\N	\N	\N	\N	\N	2026-09-03 04:24:03	2026-09-03 04:55:12	1	\N	\N	\N
1	TKT-20260902-17-0001	3	17	2	submitted	\N	\N	\N	\N	\N	2026-09-02 13:40:23	2026-09-02 13:40:23	1	\N	\N	\N
14	TKT-20260904-17-0001	3	17	3	completed	Permohonan telah selesai diproses. Anda dapat mengunduh dokumen hasil atau mengambil berkas fisik di kantor kecamatan.	\N	\N	submissions/14/output/e_dokumen_hasil_6hxCAfGC.pdf	{"f101":{"jenis_pilihan":"wni","nama_kepala_keluarga":"Ahmad Fauzi (Warga)","nik_kepala_keluarga":"3206171505980001","telepon":"085712345678","alamat":"Kp. Kaum Wetan RT 02 \\/ RW 04 No. 15, Manonjaya","rt":"001","rw":"001","kode_pos":"46182","email":"warga@portal.test","jumlah_anggota":"1","nama_provinsi":"32 - JAWA BARAT","nama_kabupaten":"06 - KAB. TASIKMALAYA","nama_kecamatan":"Manonjaya","nama_desa":"Manonjaya","nama_dusun":"Kp. Kaum Wetan RT 02 \\/ RW 04 No. 15, Manonjaya","anggota":[{"nama":"Ahmad Fauzi (Warga)","nik":"3206171505980001","jenis_kelamin":"L","tempat_lahir":"Tasikmalaya","tanggal_lahir":"2026-09-02","gol_darah":"-","agama":"Islam","shdk":"Kepala Keluarga","status_kawin":"Kawin Tercatat","pendidikan":"SLTA \\/ Sederajat","pekerjaan":"Wiraswasta","no_akta_lahir":"12","nama_ibu":"Yati","nik_ibu":"320622180601004","nama_ayah":"aep","nik_ayah":"320622180601005","disabilitas":"Tidak Ada"}]}}	2026-09-04 08:58:40	2026-09-04 09:06:32	1	9	2026-09-04 09:03:28	persyaratan sudah lengkap !
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, nik, phone, role, kecamatan_id, desa_id, alamat_detail) FROM stdin;
4	rifa fauzi	rifafauzi177@gmail.com	\N	$2y$12$8CZEDf8SXD.6YM/Yx9GhHeWobBe8FC4vPsudcFJnB2hQgQ7o4Hymu	\N	2026-08-31 04:17:26	2026-08-31 04:17:26	\N	\N	warga	17	\N	\N
5	nabillah fridayesi	nabilah20@gmail.com	\N	$2y$12$EyxRu/p8.4MA4lXLzVVHNuqAuibmKPak.uwBhKaOkdebSDb1/Fo6a	\N	2026-09-03 05:17:29	2026-09-03 05:17:29	\N	\N	warga	17	\N	\N
6	annisa aulia	anisa@gmail.com	\N	$2y$12$22iUI4Wl8WBFX0sku7P1MeLTxOX9tDAfOFFqP1F2auIRzNF.HJmwm	\N	2026-09-03 14:01:56	2026-09-03 14:01:56	\N	\N	warga	17	\N	\N
7	farhan fauzi	farhan@gmail.com	\N	$2y$12$q8znMGaWdiB72HOfbfziOe1OqaeD4UGQX05hdNVO41XcoHalCktsG	\N	2026-09-03 14:03:25	2026-09-03 14:04:20	\N	081234567890	warga	27	\N	Jl.Cipanas Galunggung
1	Super Administrator Diskominfo	superadmin@portal.test	\N	$2y$12$TzAOuuyo9n60rl.jN.h75.Q0P5glrGR2w8BfAq3BY/IIu2.nA7gly	\N	2026-08-27 06:04:07	2026-09-04 08:45:42	\N	081234567890	super_admin	\N	\N	Dinas Kominfo Kab. Tasikmalaya
2	Petugas Admin Kec. Manonjaya	admin.manonjaya@portal.test	\N	$2y$12$epAkho.or4PtBlA8A4..JO1sxtvOc1scehexqFlB0XgaphHzZXy6W	\N	2026-08-27 06:04:07	2026-09-04 08:45:42	3206170101850001	081298765432	admin_kecamatan	17	\N	Kantor Kecamatan Manonjaya, Tasikmalaya
9	Kasi Pelayanan Desa Manonjaya	kasi.manonjaya@portal.test	\N	$2y$12$CtuoYpmdlP80MpTIwYGVAeiHsJPHmKvsqn6YvuTxnPdZEj8m5YJv.	\N	2026-09-04 08:45:42	2026-09-04 08:45:42	3206170202880002	081399887766	admin_desa	17	1	Kantor Kepala Desa Manonjaya, Tasikmalaya
3	Ahmad Fauzi (Warga)	warga@portal.test	\N	$2y$12$.NtorTrHwejNdi2P9X3G9Oe1nAoIfZ3GerIGrghmpAiDkQnrYSC1i	\N	2026-08-27 06:04:07	2026-09-04 08:45:42	3206171505980001	085712345678	warga	17	1	Kp. Kaum Wetan RT 02 / RW 04 No. 15, Manonjaya
\.


--
-- Name: desas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.desas_id_seq', 12, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: kecamatans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.kecamatans_id_seq', 39, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 12, true);


--
-- Name: service_requirements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.service_requirements_id_seq', 32, true);


--
-- Name: services_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.services_id_seq', 9, true);


--
-- Name: submission_documents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.submission_documents_id_seq', 45, true);


--
-- Name: submissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.submissions_id_seq', 14, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 9, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: desas desas_kode_desa_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.desas
    ADD CONSTRAINT desas_kode_desa_unique UNIQUE (kode_desa);


--
-- Name: desas desas_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.desas
    ADD CONSTRAINT desas_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: kecamatans kecamatans_kode_kecamatan_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.kecamatans
    ADD CONSTRAINT kecamatans_kode_kecamatan_unique UNIQUE (kode_kecamatan);


--
-- Name: kecamatans kecamatans_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.kecamatans
    ADD CONSTRAINT kecamatans_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: service_requirements service_requirements_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.service_requirements
    ADD CONSTRAINT service_requirements_pkey PRIMARY KEY (id);


--
-- Name: services services_kode_layanan_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_kode_layanan_unique UNIQUE (kode_layanan);


--
-- Name: services services_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: submission_documents submission_documents_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submission_documents
    ADD CONSTRAINT submission_documents_pkey PRIMARY KEY (id);


--
-- Name: submissions submissions_nomor_tiket_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_nomor_tiket_unique UNIQUE (nomor_tiket);


--
-- Name: submissions submissions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_nik_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_nik_unique UNIQUE (nik);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: desas_kecamatan_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX desas_kecamatan_id_index ON public.desas USING btree (kecamatan_id);


--
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: service_requirements_service_id_urutan_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX service_requirements_service_id_urutan_index ON public.service_requirements USING btree (service_id, urutan);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: submission_documents_submission_id_status_validasi_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX submission_documents_submission_id_status_validasi_index ON public.submission_documents USING btree (submission_id, status_validasi);


--
-- Name: submissions_desa_id_status_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX submissions_desa_id_status_index ON public.submissions USING btree (desa_id, status);


--
-- Name: submissions_kecamatan_id_status_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX submissions_kecamatan_id_status_index ON public.submissions USING btree (kecamatan_id, status);


--
-- Name: submissions_service_id_kecamatan_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX submissions_service_id_kecamatan_id_index ON public.submissions USING btree (service_id, kecamatan_id);


--
-- Name: submissions_user_id_status_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX submissions_user_id_status_index ON public.submissions USING btree (user_id, status);


--
-- Name: users_kecamatan_id_role_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX users_kecamatan_id_role_index ON public.users USING btree (kecamatan_id, role);


--
-- Name: desas desas_kecamatan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.desas
    ADD CONSTRAINT desas_kecamatan_id_foreign FOREIGN KEY (kecamatan_id) REFERENCES public.kecamatans(id) ON DELETE CASCADE;


--
-- Name: service_requirements service_requirements_service_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.service_requirements
    ADD CONSTRAINT service_requirements_service_id_foreign FOREIGN KEY (service_id) REFERENCES public.services(id) ON DELETE CASCADE;


--
-- Name: submission_documents submission_documents_service_requirement_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submission_documents
    ADD CONSTRAINT submission_documents_service_requirement_id_foreign FOREIGN KEY (service_requirement_id) REFERENCES public.service_requirements(id) ON DELETE CASCADE;


--
-- Name: submission_documents submission_documents_submission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submission_documents
    ADD CONSTRAINT submission_documents_submission_id_foreign FOREIGN KEY (submission_id) REFERENCES public.submissions(id) ON DELETE CASCADE;


--
-- Name: submissions submissions_desa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_desa_id_foreign FOREIGN KEY (desa_id) REFERENCES public.desas(id) ON DELETE SET NULL;


--
-- Name: submissions submissions_kecamatan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_kecamatan_id_foreign FOREIGN KEY (kecamatan_id) REFERENCES public.kecamatans(id) ON DELETE CASCADE;


--
-- Name: submissions submissions_service_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_service_id_foreign FOREIGN KEY (service_id) REFERENCES public.services(id) ON DELETE CASCADE;


--
-- Name: submissions submissions_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: submissions submissions_verified_by_desa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.submissions
    ADD CONSTRAINT submissions_verified_by_desa_id_foreign FOREIGN KEY (verified_by_desa_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: users users_desa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_desa_id_foreign FOREIGN KEY (desa_id) REFERENCES public.desas(id) ON DELETE SET NULL;


--
-- Name: users users_kecamatan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_kecamatan_id_foreign FOREIGN KEY (kecamatan_id) REFERENCES public.kecamatans(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

\unrestrict YlOHoCojmNrFbEtEqbeLWg1i3yakxbhWEkmxdTPmQujnBztzTulapL5CNzI9Dbl

