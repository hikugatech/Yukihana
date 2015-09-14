apt-get update;
apt-get install -y sudo;
sudo apt-get -y --force-yes install autoconf automake build-essential libass-dev libfreetype6-dev \
  libsdl1.2-dev libtheora-dev libtool libva-dev libvdpau-dev libvorbis-dev libxcb1-dev libxcb-shm0-dev \
  libxcb-xfixes0-dev pkg-config texi2html zlib1g-dev;
  
mkdir /home/ffmpeg_sources;

sudo apt-get -y install yasm;
cd /home/ffmpeg_sources;
wget http://www.tortall.net/projects/yasm/releases/yasm-1.3.0.tar.gz;
tar xzvf yasm-1.3.0.tar.gz;
cd yasm-1.3.0;
./configure;
make;
make install;
make distclean;

sudo apt-get install -y libx264-dev;
cd /home/ffmpeg_sources;
wget http://download.videolan.org/pub/x264/snapshots/last_x264.tar.bz2;
tar xjvf last_x264.tar.bz2;
cd x264-snapshot*;
PATH="/home/bin:$PATH" ./configure --prefix="/home/ffmpeg_build" --bindir="/home/bin" --enable-static;
PATH="/home/bin:$PATH" make;
make install;
make distclean;

sudo apt-get install -y cmake mercurial;
cd /home/ffmpeg_sources;
hg clone https://bitbucket.org/multicoreware/x265;
cd /home/ffmpeg_sources/x265/build/linux;
PATH="/home/bin:$PATH" cmake -G "Unix Makefiles" -DCMAKE_INSTALL_PREFIX="/home/ffmpeg_build" -DENABLE_SHARED:bool=off ../../source;
make;
make install;
make distclean;

cd /home/ffmpeg_sources;
wget -O fdk-aac.tar.gz https://github.com/mstorsjo/fdk-aac/tarball/master;
tar xzvf fdk-aac.tar.gz;
cd mstorsjo-fdk-aac*;
autoreconf -fiv;
./configure --prefix="/home/ffmpeg_build" --disable-shared;
make;
make install;
make distclean;

sudo apt-get install -y libopus-dev;
cd /home/ffmpeg_sources;
wget http://downloads.xiph.org/releases/opus/opus-1.1.tar.gz;
tar xzvf opus-1.1.tar.gz;
cd opus-1.1;
./configure --prefix="/home/ffmpeg_build" --disable-shared;
make;
make install;
make distclean;

cd /home/ffmpeg_sources;
wget http://storage.googleapis.com/downloads.webmproject.org/releases/webm/libvpx-1.4.0.tar.bz2;
tar xjvf libvpx-1.4.0.tar.bz2;
cd libvpx-1.4.0;
PATH="/home/bin:$PATH" ./configure --prefix="/home/ffmpeg_build" --disable-examples --disable-unit-tests;
PATH="/home/bin:$PATH" make;
make install;
make clean;

cd /home/ffmpeg_sources;
wget http://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2;
tar xjvf ffmpeg-snapshot.tar.bz2;
cd ffmpeg;
PATH="/home/bin:$PATH" PKG_CONFIG_PATH="/home/ffmpeg_build/lib/pkgconfig" ./configure \
  --prefix="/home/ffmpeg_build" \
  --pkg-config-flags="--static" \
  --extra-cflags="-I/home/ffmpeg_build/include" \
  --extra-ldflags="-L/home/ffmpeg_build/lib" \
  --bindir="/home/bin" \
  --enable-gpl \
  --enable-libass \
  --enable-libfdk-aac \
  --enable-libfreetype \
  --enable-libopus \
  --enable-libtheora \
  --enable-libvorbis \
  --enable-libvpx \
  --enable-libx264 \
  --enable-libx265 \
  --enable-nonfree;
PATH="/home/bin:$PATH" make;
make install;
make distclean;
hash -r;

cd /home/ffmpeg_sources;
wget http://download.videolan.org/pub/x264/snapshots/last_x264.tar.bz2;
tar xjvf last_x264.tar.bz2;
cd x264-snapshot*;
PATH="/home/bin10bit:$PATH" ./configure --prefix="/home/ffmpeg_build10bit" --bindir="/home/bin10bit" --enable-static --bit-depth=10;
PATH="/home/bin10bit:$PATH" make;
make install;
make distclean;

cd /home/ffmpeg_sources;
wget http://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2;
tar xjvf ffmpeg-snapshot.tar.bz2;
cd ffmpeg;
PATH="/home/bin10bit:$PATH" PKG_CONFIG_PATH="/home/ffmpeg_build10bit/lib/pkgconfig" ./configure \
  --prefix="/home/ffmpeg_build10bit" \
  --pkg-config-flags="--static" \
  --extra-cflags="-I/home/ffmpeg_build10bit/include" \
  --extra-ldflags="-L/home/ffmpeg_build10bit/lib" \
  --bindir="/home/bin10bit" \
  --enable-gpl \
  --enable-libass \
  --enable-libfreetype \
  --enable-libtheora \
  --enable-libvorbis \
  --enable-libx264 \
  --enable-nonfree;
PATH="/home/bin10bit:$PATH" make;
make install;
make distclean;
hash -r;