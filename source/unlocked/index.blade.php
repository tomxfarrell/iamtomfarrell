<!doctype html>
<html class="staticrypt-html">
<head>
    <meta charset="utf-8">
    <title>Protected Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- do not cache this page -->
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <style>
        .staticrypt-hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eee;
        }

        .staticrypt-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
            box-sizing: border-box;
        }

        .staticrypt-form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .staticrypt-form input[type="password"] {
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .staticrypt-form .staticrypt-decrypt-button {
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            cursor: pointer;
        }

        .staticrypt-form .staticrypt-decrypt-button:hover, .staticrypt-form .staticrypt-decrypt-button:active, .staticrypt-form .staticrypt-decrypt-button:focus {
            background: #43A047;
        }

        .staticrypt-html {
            height: 100%;
        }

        .staticrypt-body {
            margin-bottom: 1em;
            background: #302E6F; /* fallback for old browsers */
            font-family: "Arial", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .staticrypt-instructions {
            margin-top: -1em;
            margin-bottom: 1em;
        }

        .staticrypt-title {
            font-size: 1.5em;
        }

        .staticrypt-footer {
            position: fixed;
            height: 20px;
            font-size: 16px;
            padding: 2px;
            bottom: 0;
            left: 0;
            right: 0;
            margin-bottom: 0;
        }

        .staticrypt-footer p {
            margin: 2px;
            text-align: center;
            float: right;
        }

        .staticrypt-footer a {
            text-decoration: none;
        }

        label.staticrypt-remember {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
        }

        .staticrypt-remember input[type=checkbox] {
            transform: scale(1.5);
            margin-right: 1em;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="staticrypt-body">
<div class="staticrypt-page">
    <div class="staticrypt-form">
        <div class="staticrypt-instructions">
            <p class="staticrypt-title">Protected Page</p>
            <p></p>
        </div>

        <hr class="staticrypt-hr">

        <form id="staticrypt-form" action="#" method="post">
            <input id="staticrypt-password"
                   type="password"
                   name="password"
                   placeholder="Passphrase"
                   autofocus/>

            <label id="staticrypt-remember-label" class="staticrypt-remember hidden">
                <input id="staticrypt-remember"
                       type="checkbox"
                       name="remember"/>
                Remember me
            </label>

            <input type="submit" class="staticrypt-decrypt-button" value="Unlock"/>
        </form>
    </div>

</div>
<footer class="staticrypt-footer">
    <p class="pull-right">Created with <a href="https://robinmoisson.github.io/staticrypt">StatiCrypt</a></p>
</footer>


<script>/**
 * Crypto JS 3.1.9-1
 * Copied as is from https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js
 */

;(function (root, factory) {
    if (typeof exports === "object") {
        // CommonJS
        module.exports = exports = factory();
    }
    else if (typeof define === "function" && define.amd) {
        // AMD
        define([], factory);
    }
    else {
        // Global (browser)
        root.CryptoJS = factory();
    }
}(this, function () {

    /**
     * CryptoJS core components.
     */
    var CryptoJS = CryptoJS || (function (Math, undefined) {
        /*
	     * Local polyfil of Object.create
	     */
        var create = Object.create || (function () {
            function F() {};

            return function (obj) {
                var subtype;

                F.prototype = obj;

                subtype = new F();

                F.prototype = null;

                return subtype;
            };
        }())

        /**
         * CryptoJS namespace.
         */
        var C = {};

        /**
         * Library namespace.
         */
        var C_lib = C.lib = {};

        /**
         * Base object for prototypal inheritance.
         */
        var Base = C_lib.Base = (function () {


            return {
                /**
                 * Creates a new object that inherits from this object.
                 *
                 * @param {Object} overrides Properties to copy into the new object.
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         field: 'value',
	             *
	             *         method: function () {
	             *         }
	             *     });
                 */
                extend: function (overrides) {
                    // Spawn
                    var subtype = create(this);

                    // Augment
                    if (overrides) {
                        subtype.mixIn(overrides);
                    }

                    // Create default initializer
                    if (!subtype.hasOwnProperty('init') || this.init === subtype.init) {
                        subtype.init = function () {
                            subtype.$super.init.apply(this, arguments);
                        };
                    }

                    // Initializer's prototype is the subtype object
                    subtype.init.prototype = subtype;

                    // Reference supertype
                    subtype.$super = this;

                    return subtype;
                },

                /**
                 * Extends this object and runs the init method.
                 * Arguments to create() will be passed to init().
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var instance = MyType.create();
                 */
                create: function () {
                    var instance = this.extend();
                    instance.init.apply(instance, arguments);

                    return instance;
                },

                /**
                 * Initializes a newly created object.
                 * Override this method to add some logic when your objects are created.
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         init: function () {
	             *             // ...
	             *         }
	             *     });
                 */
                init: function () {
                },

                /**
                 * Copies properties into this object.
                 *
                 * @param {Object} properties The properties to mix in.
                 *
                 * @example
                 *
                 *     MyType.mixIn({
	             *         field: 'value'
	             *     });
                 */
                mixIn: function (properties) {
                    for (var propertyName in properties) {
                        if (properties.hasOwnProperty(propertyName)) {
                            this[propertyName] = properties[propertyName];
                        }
                    }

                    // IE won't copy toString using the loop above
                    if (properties.hasOwnProperty('toString')) {
                        this.toString = properties.toString;
                    }
                },

                /**
                 * Creates a copy of this object.
                 *
                 * @return {Object} The clone.
                 *
                 * @example
                 *
                 *     var clone = instance.clone();
                 */
                clone: function () {
                    return this.init.prototype.extend(this);
                }
            };
        }());

        /**
         * An array of 32-bit words.
         *
         * @property {Array} words The array of 32-bit words.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var WordArray = C_lib.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of 32-bit words.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.create();
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607]);
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607], 6);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 4;
                }
            },

            /**
             * Converts this word array to a string.
             *
             * @param {Encoder} encoder (Optional) The encoding strategy to use. Default: CryptoJS.enc.Hex
             *
             * @return {string} The stringified word array.
             *
             * @example
             *
             *     var string = wordArray + '';
             *     var string = wordArray.toString();
             *     var string = wordArray.toString(CryptoJS.enc.Utf8);
             */
            toString: function (encoder) {
                return (encoder || Hex).stringify(this);
            },

            /**
             * Concatenates a word array to this word array.
             *
             * @param {WordArray} wordArray The word array to append.
             *
             * @return {WordArray} This word array.
             *
             * @example
             *
             *     wordArray1.concat(wordArray2);
             */
            concat: function (wordArray) {
                // Shortcuts
                var thisWords = this.words;
                var thatWords = wordArray.words;
                var thisSigBytes = this.sigBytes;
                var thatSigBytes = wordArray.sigBytes;

                // Clamp excess bits
                this.clamp();

                // Concat
                if (thisSigBytes % 4) {
                    // Copy one byte at a time
                    for (var i = 0; i < thatSigBytes; i++) {
                        var thatByte = (thatWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                        thisWords[(thisSigBytes + i) >>> 2] |= thatByte << (24 - ((thisSigBytes + i) % 4) * 8);
                    }
                } else {
                    // Copy one word at a time
                    for (var i = 0; i < thatSigBytes; i += 4) {
                        thisWords[(thisSigBytes + i) >>> 2] = thatWords[i >>> 2];
                    }
                }
                this.sigBytes += thatSigBytes;

                // Chainable
                return this;
            },

            /**
             * Removes insignificant bits.
             *
             * @example
             *
             *     wordArray.clamp();
             */
            clamp: function () {
                // Shortcuts
                var words = this.words;
                var sigBytes = this.sigBytes;

                // Clamp
                words[sigBytes >>> 2] &= 0xffffffff << (32 - (sigBytes % 4) * 8);
                words.length = Math.ceil(sigBytes / 4);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {WordArray} The clone.
             *
             * @example
             *
             *     var clone = wordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone.words = this.words.slice(0);

                return clone;
            },

            /**
             * Creates a word array filled with random bytes.
             *
             * @param {number} nBytes The number of random bytes to generate.
             *
             * @return {WordArray} The random word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.random(16);
             */
            random: function (nBytes) {
                var words = [];

                var r = (function (m_w) {
                    var m_w = m_w;
                    var m_z = 0x3ade68b1;
                    var mask = 0xffffffff;

                    return function () {
                        m_z = (0x9069 * (m_z & 0xFFFF) + (m_z >> 0x10)) & mask;
                        m_w = (0x4650 * (m_w & 0xFFFF) + (m_w >> 0x10)) & mask;
                        var result = ((m_z << 0x10) + m_w) & mask;
                        result /= 0x100000000;
                        result += 0.5;
                        return result * (Math.random() > .5 ? 1 : -1);
                    }
                });

                for (var i = 0, rcache; i < nBytes; i += 4) {
                    var _r = r((rcache || Math.random()) * 0x100000000);

                    rcache = _r() * 0x3ade67b7;
                    words.push((_r() * 0x100000000) | 0);
                }

                return new WordArray.init(words, nBytes);
            }
        });

        /**
         * Encoder namespace.
         */
        var C_enc = C.enc = {};

        /**
         * Hex encoding strategy.
         */
        var Hex = C_enc.Hex = {
            /**
             * Converts a word array to a hex string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The hex string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.enc.Hex.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var hexChars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    hexChars.push((bite >>> 4).toString(16));
                    hexChars.push((bite & 0x0f).toString(16));
                }

                return hexChars.join('');
            },

            /**
             * Converts a hex string to a word array.
             *
             * @param {string} hexStr The hex string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Hex.parse(hexString);
             */
            parse: function (hexStr) {
                // Shortcut
                var hexStrLength = hexStr.length;

                // Convert
                var words = [];
                for (var i = 0; i < hexStrLength; i += 2) {
                    words[i >>> 3] |= parseInt(hexStr.substr(i, 2), 16) << (24 - (i % 8) * 4);
                }

                return new WordArray.init(words, hexStrLength / 2);
            }
        };

        /**
         * Latin1 encoding strategy.
         */
        var Latin1 = C_enc.Latin1 = {
            /**
             * Converts a word array to a Latin1 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Latin1 string.
             *
             * @static
             *
             * @example
             *
             *     var latin1String = CryptoJS.enc.Latin1.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var latin1Chars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    latin1Chars.push(String.fromCharCode(bite));
                }

                return latin1Chars.join('');
            },

            /**
             * Converts a Latin1 string to a word array.
             *
             * @param {string} latin1Str The Latin1 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Latin1.parse(latin1String);
             */
            parse: function (latin1Str) {
                // Shortcut
                var latin1StrLength = latin1Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < latin1StrLength; i++) {
                    words[i >>> 2] |= (latin1Str.charCodeAt(i) & 0xff) << (24 - (i % 4) * 8);
                }

                return new WordArray.init(words, latin1StrLength);
            }
        };

        /**
         * UTF-8 encoding strategy.
         */
        var Utf8 = C_enc.Utf8 = {
            /**
             * Converts a word array to a UTF-8 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-8 string.
             *
             * @static
             *
             * @example
             *
             *     var utf8String = CryptoJS.enc.Utf8.stringify(wordArray);
             */
            stringify: function (wordArray) {
                try {
                    return decodeURIComponent(escape(Latin1.stringify(wordArray)));
                } catch (e) {
                    throw new Error('Malformed UTF-8 data');
                }
            },

            /**
             * Converts a UTF-8 string to a word array.
             *
             * @param {string} utf8Str The UTF-8 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf8.parse(utf8String);
             */
            parse: function (utf8Str) {
                return Latin1.parse(unescape(encodeURIComponent(utf8Str)));
            }
        };

        /**
         * Abstract buffered block algorithm template.
         *
         * The property blockSize must be implemented in a concrete subtype.
         *
         * @property {number} _minBufferSize The number of blocks that should be kept unprocessed in the buffer. Default: 0
         */
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm = Base.extend({
            /**
             * Resets this block algorithm's data buffer to its initial state.
             *
             * @example
             *
             *     bufferedBlockAlgorithm.reset();
             */
            reset: function () {
                // Initial values
                this._data = new WordArray.init();
                this._nDataBytes = 0;
            },

            /**
             * Adds new data to this block algorithm's buffer.
             *
             * @param {WordArray|string} data The data to append. Strings are converted to a WordArray using UTF-8.
             *
             * @example
             *
             *     bufferedBlockAlgorithm._append('data');
             *     bufferedBlockAlgorithm._append(wordArray);
             */
            _append: function (data) {
                // Convert string to WordArray, else assume WordArray already
                if (typeof data == 'string') {
                    data = Utf8.parse(data);
                }

                // Append
                this._data.concat(data);
                this._nDataBytes += data.sigBytes;
            },

            /**
             * Processes available data blocks.
             *
             * This method invokes _doProcessBlock(offset), which must be implemented by a concrete subtype.
             *
             * @param {boolean} doFlush Whether all blocks and partial blocks should be processed.
             *
             * @return {WordArray} The processed data.
             *
             * @example
             *
             *     var processedData = bufferedBlockAlgorithm._process();
             *     var processedData = bufferedBlockAlgorithm._process(!!'flush');
             */
            _process: function (doFlush) {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var dataSigBytes = data.sigBytes;
                var blockSize = this.blockSize;
                var blockSizeBytes = blockSize * 4;

                // Count blocks ready
                var nBlocksReady = dataSigBytes / blockSizeBytes;
                if (doFlush) {
                    // Round up to include partial blocks
                    nBlocksReady = Math.ceil(nBlocksReady);
                } else {
                    // Round down to include only full blocks,
                    // less the number of blocks that must remain in the buffer
                    nBlocksReady = Math.max((nBlocksReady | 0) - this._minBufferSize, 0);
                }

                // Count words ready
                var nWordsReady = nBlocksReady * blockSize;

                // Count bytes ready
                var nBytesReady = Math.min(nWordsReady * 4, dataSigBytes);

                // Process blocks
                if (nWordsReady) {
                    for (var offset = 0; offset < nWordsReady; offset += blockSize) {
                        // Perform concrete-algorithm logic
                        this._doProcessBlock(dataWords, offset);
                    }

                    // Remove processed words
                    var processedWords = dataWords.splice(0, nWordsReady);
                    data.sigBytes -= nBytesReady;
                }

                // Return processed words
                return new WordArray.init(processedWords, nBytesReady);
            },

            /**
             * Creates a copy of this object.
             *
             * @return {Object} The clone.
             *
             * @example
             *
             *     var clone = bufferedBlockAlgorithm.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone._data = this._data.clone();

                return clone;
            },

            _minBufferSize: 0
        });

        /**
         * Abstract hasher template.
         *
         * @property {number} blockSize The number of 32-bit words this hasher operates on. Default: 16 (512 bits)
         */
        var Hasher = C_lib.Hasher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             */
            cfg: Base.extend(),

            /**
             * Initializes a newly created hasher.
             *
             * @param {Object} cfg (Optional) The configuration options to use for this hash computation.
             *
             * @example
             *
             *     var hasher = CryptoJS.algo.SHA256.create();
             */
            init: function (cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Set initial values
                this.reset();
            },

            /**
             * Resets this hasher to its initial state.
             *
             * @example
             *
             *     hasher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-hasher logic
                this._doReset();
            },

            /**
             * Updates this hasher with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {Hasher} This hasher.
             *
             * @example
             *
             *     hasher.update('message');
             *     hasher.update(wordArray);
             */
            update: function (messageUpdate) {
                // Append
                this._append(messageUpdate);

                // Update the hash
                this._process();

                // Chainable
                return this;
            },

            /**
             * Finalizes the hash computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The hash.
             *
             * @example
             *
             *     var hash = hasher.finalize();
             *     var hash = hasher.finalize('message');
             *     var hash = hasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Final message update
                if (messageUpdate) {
                    this._append(messageUpdate);
                }

                // Perform concrete-hasher logic
                var hash = this._doFinalize();

                return hash;
            },

            blockSize: 512/32,

            /**
             * Creates a shortcut function to a hasher's object interface.
             *
             * @param {Hasher} hasher The hasher to create a helper for.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var SHA256 = CryptoJS.lib.Hasher._createHelper(CryptoJS.algo.SHA256);
             */
            _createHelper: function (hasher) {
                return function (message, cfg) {
                    return new hasher.init(cfg).finalize(message);
                };
            },

            /**
             * Creates a shortcut function to the HMAC's object interface.
             *
             * @param {Hasher} hasher The hasher to use in this HMAC helper.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var HmacSHA256 = CryptoJS.lib.Hasher._createHmacHelper(CryptoJS.algo.SHA256);
             */
            _createHmacHelper: function (hasher) {
                return function (message, key) {
                    return new C_algo.HMAC.init(hasher, key).finalize(message);
                };
            }
        });

        /**
         * Algorithm namespace.
         */
        var C_algo = C.algo = {};

        return C;
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * Base64 encoding strategy.
         */
        var Base64 = C_enc.Base64 = {
            /**
             * Converts a word array to a Base64 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Base64 string.
             *
             * @static
             *
             * @example
             *
             *     var base64String = CryptoJS.enc.Base64.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;
                var map = this._map;

                // Clamp excess bits
                wordArray.clamp();

                // Convert
                var base64Chars = [];
                for (var i = 0; i < sigBytes; i += 3) {
                    var byte1 = (words[i >>> 2]       >>> (24 - (i % 4) * 8))       & 0xff;
                    var byte2 = (words[(i + 1) >>> 2] >>> (24 - ((i + 1) % 4) * 8)) & 0xff;
                    var byte3 = (words[(i + 2) >>> 2] >>> (24 - ((i + 2) % 4) * 8)) & 0xff;

                    var triplet = (byte1 << 16) | (byte2 << 8) | byte3;

                    for (var j = 0; (j < 4) && (i + j * 0.75 < sigBytes); j++) {
                        base64Chars.push(map.charAt((triplet >>> (6 * (3 - j))) & 0x3f));
                    }
                }

                // Add padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    while (base64Chars.length % 4) {
                        base64Chars.push(paddingChar);
                    }
                }

                return base64Chars.join('');
            },

            /**
             * Converts a Base64 string to a word array.
             *
             * @param {string} base64Str The Base64 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Base64.parse(base64String);
             */
            parse: function (base64Str) {
                // Shortcuts
                var base64StrLength = base64Str.length;
                var map = this._map;
                var reverseMap = this._reverseMap;

                if (!reverseMap) {
                    reverseMap = this._reverseMap = [];
                    for (var j = 0; j < map.length; j++) {
                        reverseMap[map.charCodeAt(j)] = j;
                    }
                }

                // Ignore padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    var paddingIndex = base64Str.indexOf(paddingChar);
                    if (paddingIndex !== -1) {
                        base64StrLength = paddingIndex;
                    }
                }

                // Convert
                return parseLoop(base64Str, base64StrLength, reverseMap);

            },

            _map: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
        };

        function parseLoop(base64Str, base64StrLength, reverseMap) {
            var words = [];
            var nBytes = 0;
            for (var i = 0; i < base64StrLength; i++) {
                if (i % 4) {
                    var bits1 = reverseMap[base64Str.charCodeAt(i - 1)] << ((i % 4) * 2);
                    var bits2 = reverseMap[base64Str.charCodeAt(i)] >>> (6 - (i % 4) * 2);
                    words[nBytes >>> 2] |= (bits1 | bits2) << (24 - (nBytes % 4) * 8);
                    nBytes++;
                }
            }
            return WordArray.create(words, nBytes);
        }
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var T = [];

        // Compute constants
        (function () {
            for (var i = 0; i < 64; i++) {
                T[i] = (Math.abs(Math.sin(i + 1)) * 0x100000000) | 0;
            }
        }());

        /**
         * MD5 hash algorithm.
         */
        var MD5 = C_algo.MD5 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }

                // Shortcuts
                var H = this._hash.words;

                var M_offset_0  = M[offset + 0];
                var M_offset_1  = M[offset + 1];
                var M_offset_2  = M[offset + 2];
                var M_offset_3  = M[offset + 3];
                var M_offset_4  = M[offset + 4];
                var M_offset_5  = M[offset + 5];
                var M_offset_6  = M[offset + 6];
                var M_offset_7  = M[offset + 7];
                var M_offset_8  = M[offset + 8];
                var M_offset_9  = M[offset + 9];
                var M_offset_10 = M[offset + 10];
                var M_offset_11 = M[offset + 11];
                var M_offset_12 = M[offset + 12];
                var M_offset_13 = M[offset + 13];
                var M_offset_14 = M[offset + 14];
                var M_offset_15 = M[offset + 15];

                // Working varialbes
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];

                // Computation
                a = FF(a, b, c, d, M_offset_0,  7,  T[0]);
                d = FF(d, a, b, c, M_offset_1,  12, T[1]);
                c = FF(c, d, a, b, M_offset_2,  17, T[2]);
                b = FF(b, c, d, a, M_offset_3,  22, T[3]);
                a = FF(a, b, c, d, M_offset_4,  7,  T[4]);
                d = FF(d, a, b, c, M_offset_5,  12, T[5]);
                c = FF(c, d, a, b, M_offset_6,  17, T[6]);
                b = FF(b, c, d, a, M_offset_7,  22, T[7]);
                a = FF(a, b, c, d, M_offset_8,  7,  T[8]);
                d = FF(d, a, b, c, M_offset_9,  12, T[9]);
                c = FF(c, d, a, b, M_offset_10, 17, T[10]);
                b = FF(b, c, d, a, M_offset_11, 22, T[11]);
                a = FF(a, b, c, d, M_offset_12, 7,  T[12]);
                d = FF(d, a, b, c, M_offset_13, 12, T[13]);
                c = FF(c, d, a, b, M_offset_14, 17, T[14]);
                b = FF(b, c, d, a, M_offset_15, 22, T[15]);

                a = GG(a, b, c, d, M_offset_1,  5,  T[16]);
                d = GG(d, a, b, c, M_offset_6,  9,  T[17]);
                c = GG(c, d, a, b, M_offset_11, 14, T[18]);
                b = GG(b, c, d, a, M_offset_0,  20, T[19]);
                a = GG(a, b, c, d, M_offset_5,  5,  T[20]);
                d = GG(d, a, b, c, M_offset_10, 9,  T[21]);
                c = GG(c, d, a, b, M_offset_15, 14, T[22]);
                b = GG(b, c, d, a, M_offset_4,  20, T[23]);
                a = GG(a, b, c, d, M_offset_9,  5,  T[24]);
                d = GG(d, a, b, c, M_offset_14, 9,  T[25]);
                c = GG(c, d, a, b, M_offset_3,  14, T[26]);
                b = GG(b, c, d, a, M_offset_8,  20, T[27]);
                a = GG(a, b, c, d, M_offset_13, 5,  T[28]);
                d = GG(d, a, b, c, M_offset_2,  9,  T[29]);
                c = GG(c, d, a, b, M_offset_7,  14, T[30]);
                b = GG(b, c, d, a, M_offset_12, 20, T[31]);

                a = HH(a, b, c, d, M_offset_5,  4,  T[32]);
                d = HH(d, a, b, c, M_offset_8,  11, T[33]);
                c = HH(c, d, a, b, M_offset_11, 16, T[34]);
                b = HH(b, c, d, a, M_offset_14, 23, T[35]);
                a = HH(a, b, c, d, M_offset_1,  4,  T[36]);
                d = HH(d, a, b, c, M_offset_4,  11, T[37]);
                c = HH(c, d, a, b, M_offset_7,  16, T[38]);
                b = HH(b, c, d, a, M_offset_10, 23, T[39]);
                a = HH(a, b, c, d, M_offset_13, 4,  T[40]);
                d = HH(d, a, b, c, M_offset_0,  11, T[41]);
                c = HH(c, d, a, b, M_offset_3,  16, T[42]);
                b = HH(b, c, d, a, M_offset_6,  23, T[43]);
                a = HH(a, b, c, d, M_offset_9,  4,  T[44]);
                d = HH(d, a, b, c, M_offset_12, 11, T[45]);
                c = HH(c, d, a, b, M_offset_15, 16, T[46]);
                b = HH(b, c, d, a, M_offset_2,  23, T[47]);

                a = II(a, b, c, d, M_offset_0,  6,  T[48]);
                d = II(d, a, b, c, M_offset_7,  10, T[49]);
                c = II(c, d, a, b, M_offset_14, 15, T[50]);
                b = II(b, c, d, a, M_offset_5,  21, T[51]);
                a = II(a, b, c, d, M_offset_12, 6,  T[52]);
                d = II(d, a, b, c, M_offset_3,  10, T[53]);
                c = II(c, d, a, b, M_offset_10, 15, T[54]);
                b = II(b, c, d, a, M_offset_1,  21, T[55]);
                a = II(a, b, c, d, M_offset_8,  6,  T[56]);
                d = II(d, a, b, c, M_offset_15, 10, T[57]);
                c = II(c, d, a, b, M_offset_6,  15, T[58]);
                b = II(b, c, d, a, M_offset_13, 21, T[59]);
                a = II(a, b, c, d, M_offset_4,  6,  T[60]);
                d = II(d, a, b, c, M_offset_11, 10, T[61]);
                c = II(c, d, a, b, M_offset_2,  15, T[62]);
                b = II(b, c, d, a, M_offset_9,  21, T[63]);

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);

                var nBitsTotalH = Math.floor(nBitsTotal / 0x100000000);
                var nBitsTotalL = nBitsTotal;
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = (
                    (((nBitsTotalH << 8)  | (nBitsTotalH >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalH << 24) | (nBitsTotalH >>> 8))  & 0xff00ff00)
                );
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotalL << 8)  | (nBitsTotalL >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalL << 24) | (nBitsTotalL >>> 8))  & 0xff00ff00)
                );

                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    // Shortcut
                    var H_i = H[i];

                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        function FF(a, b, c, d, x, s, t) {
            var n = a + ((b & c) | (~b & d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function GG(a, b, c, d, x, s, t) {
            var n = a + ((b & d) | (c & ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function HH(a, b, c, d, x, s, t) {
            var n = a + (b ^ c ^ d) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function II(a, b, c, d, x, s, t) {
            var n = a + (c ^ (b | ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.MD5('message');
         *     var hash = CryptoJS.MD5(wordArray);
         */
        C.MD5 = Hasher._createHelper(MD5);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacMD5(message, key);
         */
        C.HmacMD5 = Hasher._createHmacHelper(MD5);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Reusable object
        var W = [];

        /**
         * SHA-1 hash algorithm.
         */
        var SHA1 = C_algo.SHA1 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476,
                    0xc3d2e1f0
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];

                // Computation
                for (var i = 0; i < 80; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var n = W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16];
                        W[i] = (n << 1) | (n >>> 31);
                    }

                    var t = ((a << 5) | (a >>> 27)) + e + W[i];
                    if (i < 20) {
                        t += ((b & c) | (~b & d)) + 0x5a827999;
                    } else if (i < 40) {
                        t += (b ^ c ^ d) + 0x6ed9eba1;
                    } else if (i < 60) {
                        t += ((b & c) | (b & d) | (c & d)) - 0x70e44324;
                    } else /* if (i < 80) */ {
                        t += (b ^ c ^ d) - 0x359d3e2a;
                    }

                    e = d;
                    d = c;
                    c = (b << 30) | (b >>> 2);
                    b = a;
                    a = t;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA1('message');
         *     var hash = CryptoJS.SHA1(wordArray);
         */
        C.SHA1 = Hasher._createHelper(SHA1);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA1(message, key);
         */
        C.HmacSHA1 = Hasher._createHmacHelper(SHA1);
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Initialization and round constants tables
        var H = [];
        var K = [];

        // Compute constants
        (function () {
            function isPrime(n) {
                var sqrtN = Math.sqrt(n);
                for (var factor = 2; factor <= sqrtN; factor++) {
                    if (!(n % factor)) {
                        return false;
                    }
                }

                return true;
            }

            function getFractionalBits(n) {
                return ((n - (n | 0)) * 0x100000000) | 0;
            }

            var n = 2;
            var nPrime = 0;
            while (nPrime < 64) {
                if (isPrime(n)) {
                    if (nPrime < 8) {
                        H[nPrime] = getFractionalBits(Math.pow(n, 1 / 2));
                    }
                    K[nPrime] = getFractionalBits(Math.pow(n, 1 / 3));

                    nPrime++;
                }

                n++;
            }
        }());

        // Reusable object
        var W = [];

        /**
         * SHA-256 hash algorithm.
         */
        var SHA256 = C_algo.SHA256 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init(H.slice(0));
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];
                var f = H[5];
                var g = H[6];
                var h = H[7];

                // Computation
                for (var i = 0; i < 64; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var gamma0x = W[i - 15];
                        var gamma0  = ((gamma0x << 25) | (gamma0x >>> 7))  ^
                            ((gamma0x << 14) | (gamma0x >>> 18)) ^
                            (gamma0x >>> 3);

                        var gamma1x = W[i - 2];
                        var gamma1  = ((gamma1x << 15) | (gamma1x >>> 17)) ^
                            ((gamma1x << 13) | (gamma1x >>> 19)) ^
                            (gamma1x >>> 10);

                        W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16];
                    }

                    var ch  = (e & f) ^ (~e & g);
                    var maj = (a & b) ^ (a & c) ^ (b & c);

                    var sigma0 = ((a << 30) | (a >>> 2)) ^ ((a << 19) | (a >>> 13)) ^ ((a << 10) | (a >>> 22));
                    var sigma1 = ((e << 26) | (e >>> 6)) ^ ((e << 21) | (e >>> 11)) ^ ((e << 7)  | (e >>> 25));

                    var t1 = h + sigma1 + ch + K[i] + W[i];
                    var t2 = sigma0 + maj;

                    h = g;
                    g = f;
                    f = e;
                    e = (d + t1) | 0;
                    d = c;
                    c = b;
                    b = a;
                    a = (t1 + t2) | 0;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
                H[5] = (H[5] + f) | 0;
                H[6] = (H[6] + g) | 0;
                H[7] = (H[7] + h) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA256('message');
         *     var hash = CryptoJS.SHA256(wordArray);
         */
        C.SHA256 = Hasher._createHelper(SHA256);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA256(message, key);
         */
        C.HmacSHA256 = Hasher._createHmacHelper(SHA256);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * UTF-16 BE encoding strategy.
         */
        var Utf16BE = C_enc.Utf16 = C_enc.Utf16BE = {
            /**
             * Converts a word array to a UTF-16 BE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 BE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16String = CryptoJS.enc.Utf16.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = (words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff;
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 BE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 BE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16.parse(utf16String);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= utf16Str.charCodeAt(i) << (16 - (i % 2) * 16);
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        /**
         * UTF-16 LE encoding strategy.
         */
        C_enc.Utf16LE = {
            /**
             * Converts a word array to a UTF-16 LE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 LE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16Str = CryptoJS.enc.Utf16LE.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = swapEndian((words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff);
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 LE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 LE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16LE.parse(utf16Str);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= swapEndian(utf16Str.charCodeAt(i) << (16 - (i % 2) * 16));
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        function swapEndian(word) {
            return ((word << 8) & 0xff00ff00) | ((word >>> 8) & 0x00ff00ff);
        }
    }());


    (function () {
        // Check if typed arrays are supported
        if (typeof ArrayBuffer != 'function') {
            return;
        }

        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;

        // Reference original init
        var superInit = WordArray.init;

        // Augment WordArray.init to handle typed arrays
        var subInit = WordArray.init = function (typedArray) {
            // Convert buffers to uint8
            if (typedArray instanceof ArrayBuffer) {
                typedArray = new Uint8Array(typedArray);
            }

            // Convert other array views to uint8
            if (
                typedArray instanceof Int8Array ||
                (typeof Uint8ClampedArray !== "undefined" && typedArray instanceof Uint8ClampedArray) ||
                typedArray instanceof Int16Array ||
                typedArray instanceof Uint16Array ||
                typedArray instanceof Int32Array ||
                typedArray instanceof Uint32Array ||
                typedArray instanceof Float32Array ||
                typedArray instanceof Float64Array
            ) {
                typedArray = new Uint8Array(typedArray.buffer, typedArray.byteOffset, typedArray.byteLength);
            }

            // Handle Uint8Array
            if (typedArray instanceof Uint8Array) {
                // Shortcut
                var typedArrayByteLength = typedArray.byteLength;

                // Extract bytes
                var words = [];
                for (var i = 0; i < typedArrayByteLength; i++) {
                    words[i >>> 2] |= typedArray[i] << (24 - (i % 4) * 8);
                }

                // Initialize this word array
                superInit.call(this, words, typedArrayByteLength);
            } else {
                // Else call normal init
                superInit.apply(this, arguments);
            }
        };

        subInit.prototype = WordArray;
    }());


    /** @preserve
     (c) 2012 by Cédric Mesnil. All rights reserved.

     Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

     - Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
     - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

     THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     */

    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var _zl = WordArray.create([
            0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15,
            7,  4, 13,  1, 10,  6, 15,  3, 12,  0,  9,  5,  2, 14, 11,  8,
            3, 10, 14,  4,  9, 15,  8,  1,  2,  7,  0,  6, 13, 11,  5, 12,
            1,  9, 11, 10,  0,  8, 12,  4, 13,  3,  7, 15, 14,  5,  6,  2,
            4,  0,  5,  9,  7, 12,  2, 10, 14,  1,  3,  8, 11,  6, 15, 13]);
        var _zr = WordArray.create([
            5, 14,  7,  0,  9,  2, 11,  4, 13,  6, 15,  8,  1, 10,  3, 12,
            6, 11,  3,  7,  0, 13,  5, 10, 14, 15,  8, 12,  4,  9,  1,  2,
            15,  5,  1,  3,  7, 14,  6,  9, 11,  8, 12,  2, 10,  0,  4, 13,
            8,  6,  4,  1,  3, 11, 15,  0,  5, 12,  2, 13,  9,  7, 10, 14,
            12, 15, 10,  4,  1,  5,  8,  7,  6,  2, 13, 14,  0,  3,  9, 11]);
        var _sl = WordArray.create([
            11, 14, 15, 12,  5,  8,  7,  9, 11, 13, 14, 15,  6,  7,  9,  8,
            7, 6,   8, 13, 11,  9,  7, 15,  7, 12, 15,  9, 11,  7, 13, 12,
            11, 13,  6,  7, 14,  9, 13, 15, 14,  8, 13,  6,  5, 12,  7,  5,
            11, 12, 14, 15, 14, 15,  9,  8,  9, 14,  5,  6,  8,  6,  5, 12,
            9, 15,  5, 11,  6,  8, 13, 12,  5, 12, 13, 14, 11,  8,  5,  6 ]);
        var _sr = WordArray.create([
            8,  9,  9, 11, 13, 15, 15,  5,  7,  7,  8, 11, 14, 14, 12,  6,
            9, 13, 15,  7, 12,  8,  9, 11,  7,  7, 12,  7,  6, 15, 13, 11,
            9,  7, 15, 11,  8,  6,  6, 14, 12, 13,  5, 14, 13, 13,  7,  5,
            15,  5,  8, 11, 14, 14,  6, 14,  6,  9, 12,  9, 12,  5, 15,  8,
            8,  5, 12,  9, 12,  5, 14,  6,  8, 13,  6,  5, 15, 13, 11, 11 ]);

        var _hl =  WordArray.create([ 0x00000000, 0x5A827999, 0x6ED9EBA1, 0x8F1BBCDC, 0xA953FD4E]);
        var _hr =  WordArray.create([ 0x50A28BE6, 0x5C4DD124, 0x6D703EF3, 0x7A6D76E9, 0x00000000]);

        /**
         * RIPEMD160 hash algorithm.
         */
        var RIPEMD160 = C_algo.RIPEMD160 = Hasher.extend({
            _doReset: function () {
                this._hash  = WordArray.create([0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0]);
            },

            _doProcessBlock: function (M, offset) {

                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    // Swap
                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }
                // Shortcut
                var H  = this._hash.words;
                var hl = _hl.words;
                var hr = _hr.words;
                var zl = _zl.words;
                var zr = _zr.words;
                var sl = _sl.words;
                var sr = _sr.words;

                // Working variables
                var al, bl, cl, dl, el;
                var ar, br, cr, dr, er;

                ar = al = H[0];
                br = bl = H[1];
                cr = cl = H[2];
                dr = dl = H[3];
                er = el = H[4];
                // Computation
                var t;
                for (var i = 0; i < 80; i += 1) {
                    t = (al +  M[offset+zl[i]])|0;
                    if (i<16){
                        t +=  f1(bl,cl,dl) + hl[0];
                    } else if (i<32) {
                        t +=  f2(bl,cl,dl) + hl[1];
                    } else if (i<48) {
                        t +=  f3(bl,cl,dl) + hl[2];
                    } else if (i<64) {
                        t +=  f4(bl,cl,dl) + hl[3];
                    } else {// if (i<80) {
                        t +=  f5(bl,cl,dl) + hl[4];
                    }
                    t = t|0;
                    t =  rotl(t,sl[i]);
                    t = (t+el)|0;
                    al = el;
                    el = dl;
                    dl = rotl(cl, 10);
                    cl = bl;
                    bl = t;

                    t = (ar + M[offset+zr[i]])|0;
                    if (i<16){
                        t +=  f5(br,cr,dr) + hr[0];
                    } else if (i<32) {
                        t +=  f4(br,cr,dr) + hr[1];
                    } else if (i<48) {
                        t +=  f3(br,cr,dr) + hr[2];
                    } else if (i<64) {
                        t +=  f2(br,cr,dr) + hr[3];
                    } else {// if (i<80) {
                        t +=  f1(br,cr,dr) + hr[4];
                    }
                    t = t|0;
                    t =  rotl(t,sr[i]) ;
                    t = (t+er)|0;
                    ar = er;
                    er = dr;
                    dr = rotl(cr, 10);
                    cr = br;
                    br = t;
                }
                // Intermediate hash value
                t    = (H[1] + cl + dr)|0;
                H[1] = (H[2] + dl + er)|0;
                H[2] = (H[3] + el + ar)|0;
                H[3] = (H[4] + al + br)|0;
                H[4] = (H[0] + bl + cr)|0;
                H[0] =  t;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotal << 8)  | (nBitsTotal >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotal << 24) | (nBitsTotal >>> 8))  & 0xff00ff00)
                );
                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 5; i++) {
                    // Shortcut
                    var H_i = H[i];

                    // Swap
                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });


        function f1(x, y, z) {
            return ((x) ^ (y) ^ (z));

        }

        function f2(x, y, z) {
            return (((x)&(y)) | ((~x)&(z)));
        }

        function f3(x, y, z) {
            return (((x) | (~(y))) ^ (z));
        }

        function f4(x, y, z) {
            return (((x) & (z)) | ((y)&(~(z))));
        }

        function f5(x, y, z) {
            return ((x) ^ ((y) |(~(z))));

        }

        function rotl(x,n) {
            return (x<<n) | (x>>>(32-n));
        }


        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.RIPEMD160('message');
         *     var hash = CryptoJS.RIPEMD160(wordArray);
         */
        C.RIPEMD160 = Hasher._createHelper(RIPEMD160);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacRIPEMD160(message, key);
         */
        C.HmacRIPEMD160 = Hasher._createHmacHelper(RIPEMD160);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var C_algo = C.algo;

        /**
         * HMAC algorithm.
         */
        var HMAC = C_algo.HMAC = Base.extend({
            /**
             * Initializes a newly created HMAC.
             *
             * @param {Hasher} hasher The hash algorithm to use.
             * @param {WordArray|string} key The secret key.
             *
             * @example
             *
             *     var hmacHasher = CryptoJS.algo.HMAC.create(CryptoJS.algo.SHA256, key);
             */
            init: function (hasher, key) {
                // Init hasher
                hasher = this._hasher = new hasher.init();

                // Convert string to WordArray, else assume WordArray already
                if (typeof key == 'string') {
                    key = Utf8.parse(key);
                }

                // Shortcuts
                var hasherBlockSize = hasher.blockSize;
                var hasherBlockSizeBytes = hasherBlockSize * 4;

                // Allow arbitrary length keys
                if (key.sigBytes > hasherBlockSizeBytes) {
                    key = hasher.finalize(key);
                }

                // Clamp excess bits
                key.clamp();

                // Clone key for inner and outer pads
                var oKey = this._oKey = key.clone();
                var iKey = this._iKey = key.clone();

                // Shortcuts
                var oKeyWords = oKey.words;
                var iKeyWords = iKey.words;

                // XOR keys with pad constants
                for (var i = 0; i < hasherBlockSize; i++) {
                    oKeyWords[i] ^= 0x5c5c5c5c;
                    iKeyWords[i] ^= 0x36363636;
                }
                oKey.sigBytes = iKey.sigBytes = hasherBlockSizeBytes;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this HMAC to its initial state.
             *
             * @example
             *
             *     hmacHasher.reset();
             */
            reset: function () {
                // Shortcut
                var hasher = this._hasher;

                // Reset
                hasher.reset();
                hasher.update(this._iKey);
            },

            /**
             * Updates this HMAC with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {HMAC} This HMAC instance.
             *
             * @example
             *
             *     hmacHasher.update('message');
             *     hmacHasher.update(wordArray);
             */
            update: function (messageUpdate) {
                this._hasher.update(messageUpdate);

                // Chainable
                return this;
            },

            /**
             * Finalizes the HMAC computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The HMAC.
             *
             * @example
             *
             *     var hmac = hmacHasher.finalize();
             *     var hmac = hmacHasher.finalize('message');
             *     var hmac = hmacHasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Shortcut
                var hasher = this._hasher;

                // Compute HMAC
                var innerHash = hasher.finalize(messageUpdate);
                hasher.reset();
                var hmac = hasher.finalize(this._oKey.clone().concat(innerHash));

                return hmac;
            }
        });
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA1 = C_algo.SHA1;
        var HMAC = C_algo.HMAC;

        /**
         * Password-Based Key Derivation Function 2 algorithm.
         */
        var PBKDF2 = C_algo.PBKDF2 = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hasher to use. Default: SHA1
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: SHA1,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.PBKDF2.create();
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Computes the Password-Based Key Derivation Function 2.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init HMAC
                var hmac = HMAC.create(cfg.hasher, password);

                // Initial values
                var derivedKey = WordArray.create();
                var blockIndex = WordArray.create([0x00000001]);

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var blockIndexWords = blockIndex.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    var block = hmac.update(salt).finalize(blockIndex);
                    hmac.reset();

                    // Shortcuts
                    var blockWords = block.words;
                    var blockWordsLength = blockWords.length;

                    // Iterations
                    var intermediate = block;
                    for (var i = 1; i < iterations; i++) {
                        intermediate = hmac.finalize(intermediate);
                        hmac.reset();

                        // Shortcut
                        var intermediateWords = intermediate.words;

                        // XOR intermediate with block
                        for (var j = 0; j < blockWordsLength; j++) {
                            blockWords[j] ^= intermediateWords[j];
                        }
                    }

                    derivedKey.concat(block);
                    blockIndexWords[0]++;
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Computes the Password-Based Key Derivation Function 2.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.PBKDF2(password, salt);
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8 });
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.PBKDF2 = function (password, salt, cfg) {
            return PBKDF2.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var MD5 = C_algo.MD5;

        /**
         * This key derivation function is meant to conform with EVP_BytesToKey.
         * www.openssl.org/docs/crypto/EVP_BytesToKey.html
         */
        var EvpKDF = C_algo.EvpKDF = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hash algorithm to use. Default: MD5
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: MD5,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.EvpKDF.create();
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Derives a key from a password.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init hasher
                var hasher = cfg.hasher.create();

                // Initial values
                var derivedKey = WordArray.create();

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    if (block) {
                        hasher.update(block);
                    }
                    var block = hasher.update(password).finalize(salt);
                    hasher.reset();

                    // Iterations
                    for (var i = 1; i < iterations; i++) {
                        block = hasher.finalize(block);
                        hasher.reset();
                    }

                    derivedKey.concat(block);
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Derives a key from a password.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.EvpKDF(password, salt);
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8 });
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.EvpKDF = function (password, salt, cfg) {
            return EvpKDF.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA256 = C_algo.SHA256;

        /**
         * SHA-224 hash algorithm.
         */
        var SHA224 = C_algo.SHA224 = SHA256.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0xc1059ed8, 0x367cd507, 0x3070dd17, 0xf70e5939,
                    0xffc00b31, 0x68581511, 0x64f98fa7, 0xbefa4fa4
                ]);
            },

            _doFinalize: function () {
                var hash = SHA256._doFinalize.call(this);

                hash.sigBytes -= 4;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA224('message');
         *     var hash = CryptoJS.SHA224(wordArray);
         */
        C.SHA224 = SHA256._createHelper(SHA224);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA224(message, key);
         */
        C.HmacSHA224 = SHA256._createHmacHelper(SHA224);
    }());


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var X32WordArray = C_lib.WordArray;

        /**
         * x64 namespace.
         */
        var C_x64 = C.x64 = {};

        /**
         * A 64-bit word.
         */
        var X64Word = C_x64.Word = Base.extend({
            /**
             * Initializes a newly created 64-bit word.
             *
             * @param {number} high The high 32 bits.
             * @param {number} low The low 32 bits.
             *
             * @example
             *
             *     var x64Word = CryptoJS.x64.Word.create(0x00010203, 0x04050607);
             */
            init: function (high, low) {
                this.high = high;
                this.low = low;
            }

            /**
             * Bitwise NOTs this word.
             *
             * @return {X64Word} A new x64-Word object after negating.
             *
             * @example
             *
             *     var negated = x64Word.not();
             */
            // not: function () {
            // var high = ~this.high;
            // var low = ~this.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ANDs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to AND with this word.
             *
             * @return {X64Word} A new x64-Word object after ANDing.
             *
             * @example
             *
             *     var anded = x64Word.and(anotherX64Word);
             */
            // and: function (word) {
            // var high = this.high & word.high;
            // var low = this.low & word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to OR with this word.
             *
             * @return {X64Word} A new x64-Word object after ORing.
             *
             * @example
             *
             *     var ored = x64Word.or(anotherX64Word);
             */
            // or: function (word) {
            // var high = this.high | word.high;
            // var low = this.low | word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise XORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to XOR with this word.
             *
             * @return {X64Word} A new x64-Word object after XORing.
             *
             * @example
             *
             *     var xored = x64Word.xor(anotherX64Word);
             */
            // xor: function (word) {
            // var high = this.high ^ word.high;
            // var low = this.low ^ word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the left.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftL(25);
             */
            // shiftL: function (n) {
            // if (n < 32) {
            // var high = (this.high << n) | (this.low >>> (32 - n));
            // var low = this.low << n;
            // } else {
            // var high = this.low << (n - 32);
            // var low = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the right.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftR(7);
             */
            // shiftR: function (n) {
            // if (n < 32) {
            // var low = (this.low >>> n) | (this.high << (32 - n));
            // var high = this.high >>> n;
            // } else {
            // var low = this.high >>> (n - 32);
            // var high = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Rotates this word n bits to the left.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotL(25);
             */
            // rotL: function (n) {
            // return this.shiftL(n).or(this.shiftR(64 - n));
            // },

            /**
             * Rotates this word n bits to the right.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotR(7);
             */
            // rotR: function (n) {
            // return this.shiftR(n).or(this.shiftL(64 - n));
            // },

            /**
             * Adds this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to add with this word.
             *
             * @return {X64Word} A new x64-Word object after adding.
             *
             * @example
             *
             *     var added = x64Word.add(anotherX64Word);
             */
            // add: function (word) {
            // var low = (this.low + word.low) | 0;
            // var carry = (low >>> 0) < (this.low >>> 0) ? 1 : 0;
            // var high = (this.high + word.high + carry) | 0;

            // return X64Word.create(high, low);
            // }
        });

        /**
         * An array of 64-bit words.
         *
         * @property {Array} words The array of CryptoJS.x64.Word objects.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var X64WordArray = C_x64.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of CryptoJS.x64.Word objects.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.x64.WordArray.create();
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ]);
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ], 10);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 8;
                }
            },

            /**
             * Converts this 64-bit word array to a 32-bit word array.
             *
             * @return {CryptoJS.lib.WordArray} This word array's data as a 32-bit word array.
             *
             * @example
             *
             *     var x32WordArray = x64WordArray.toX32();
             */
            toX32: function () {
                // Shortcuts
                var x64Words = this.words;
                var x64WordsLength = x64Words.length;

                // Convert
                var x32Words = [];
                for (var i = 0; i < x64WordsLength; i++) {
                    var x64Word = x64Words[i];
                    x32Words.push(x64Word.high);
                    x32Words.push(x64Word.low);
                }

                return X32WordArray.create(x32Words, this.sigBytes);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {X64WordArray} The clone.
             *
             * @example
             *
             *     var clone = x64WordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);

                // Clone "words" array
                var words = clone.words = this.words.slice(0);

                // Clone each X64Word object
                var wordsLength = words.length;
                for (var i = 0; i < wordsLength; i++) {
                    words[i] = words[i].clone();
                }

                return clone;
            }
        });
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var C_algo = C.algo;

        // Constants tables
        var RHO_OFFSETS = [];
        var PI_INDEXES  = [];
        var ROUND_CONSTANTS = [];

        // Compute Constants
        (function () {
            // Compute rho offset constants
            var x = 1, y = 0;
            for (var t = 0; t < 24; t++) {
                RHO_OFFSETS[x + 5 * y] = ((t + 1) * (t + 2) / 2) % 64;

                var newX = y % 5;
                var newY = (2 * x + 3 * y) % 5;
                x = newX;
                y = newY;
            }

            // Compute pi index constants
            for (var x = 0; x < 5; x++) {
                for (var y = 0; y < 5; y++) {
                    PI_INDEXES[x + 5 * y] = y + ((2 * x + 3 * y) % 5) * 5;
                }
            }

            // Compute round constants
            var LFSR = 0x01;
            for (var i = 0; i < 24; i++) {
                var roundConstantMsw = 0;
                var roundConstantLsw = 0;

                for (var j = 0; j < 7; j++) {
                    if (LFSR & 0x01) {
                        var bitPosition = (1 << j) - 1;
                        if (bitPosition < 32) {
                            roundConstantLsw ^= 1 << bitPosition;
                        } else /* if (bitPosition >= 32) */ {
                            roundConstantMsw ^= 1 << (bitPosition - 32);
                        }
                    }

                    // Compute next LFSR
                    if (LFSR & 0x80) {
                        // Primitive polynomial over GF(2): x^8 + x^6 + x^5 + x^4 + 1
                        LFSR = (LFSR << 1) ^ 0x71;
                    } else {
                        LFSR <<= 1;
                    }
                }

                ROUND_CONSTANTS[i] = X64Word.create(roundConstantMsw, roundConstantLsw);
            }
        }());

        // Reusable objects for temporary values
        var T = [];
        (function () {
            for (var i = 0; i < 25; i++) {
                T[i] = X64Word.create();
            }
        }());

        /**
         * SHA-3 hash algorithm.
         */
        var SHA3 = C_algo.SHA3 = Hasher.extend({
            /**
             * Configuration options.
             *
             * @property {number} outputLength
             *   The desired number of bits in the output hash.
             *   Only values permitted are: 224, 256, 384, 512.
             *   Default: 512
             */
            cfg: Hasher.cfg.extend({
                outputLength: 512
            }),

            _doReset: function () {
                var state = this._state = []
                for (var i = 0; i < 25; i++) {
                    state[i] = new X64Word.init();
                }

                this.blockSize = (1600 - 2 * this.cfg.outputLength) / 32;
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var state = this._state;
                var nBlockSizeLanes = this.blockSize / 2;

                // Absorb
                for (var i = 0; i < nBlockSizeLanes; i++) {
                    // Shortcuts
                    var M2i  = M[offset + 2 * i];
                    var M2i1 = M[offset + 2 * i + 1];

                    // Swap endian
                    M2i = (
                        (((M2i << 8)  | (M2i >>> 24)) & 0x00ff00ff) |
                        (((M2i << 24) | (M2i >>> 8))  & 0xff00ff00)
                    );
                    M2i1 = (
                        (((M2i1 << 8)  | (M2i1 >>> 24)) & 0x00ff00ff) |
                        (((M2i1 << 24) | (M2i1 >>> 8))  & 0xff00ff00)
                    );

                    // Absorb message into state
                    var lane = state[i];
                    lane.high ^= M2i1;
                    lane.low  ^= M2i;
                }

                // Rounds
                for (var round = 0; round < 24; round++) {
                    // Theta
                    for (var x = 0; x < 5; x++) {
                        // Mix column lanes
                        var tMsw = 0, tLsw = 0;
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            tMsw ^= lane.high;
                            tLsw ^= lane.low;
                        }

                        // Temporary values
                        var Tx = T[x];
                        Tx.high = tMsw;
                        Tx.low  = tLsw;
                    }
                    for (var x = 0; x < 5; x++) {
                        // Shortcuts
                        var Tx4 = T[(x + 4) % 5];
                        var Tx1 = T[(x + 1) % 5];
                        var Tx1Msw = Tx1.high;
                        var Tx1Lsw = Tx1.low;

                        // Mix surrounding columns
                        var tMsw = Tx4.high ^ ((Tx1Msw << 1) | (Tx1Lsw >>> 31));
                        var tLsw = Tx4.low  ^ ((Tx1Lsw << 1) | (Tx1Msw >>> 31));
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            lane.high ^= tMsw;
                            lane.low  ^= tLsw;
                        }
                    }

                    // Rho Pi
                    for (var laneIndex = 1; laneIndex < 25; laneIndex++) {
                        // Shortcuts
                        var lane = state[laneIndex];
                        var laneMsw = lane.high;
                        var laneLsw = lane.low;
                        var rhoOffset = RHO_OFFSETS[laneIndex];

                        // Rotate lanes
                        if (rhoOffset < 32) {
                            var tMsw = (laneMsw << rhoOffset) | (laneLsw >>> (32 - rhoOffset));
                            var tLsw = (laneLsw << rhoOffset) | (laneMsw >>> (32 - rhoOffset));
                        } else /* if (rhoOffset >= 32) */ {
                            var tMsw = (laneLsw << (rhoOffset - 32)) | (laneMsw >>> (64 - rhoOffset));
                            var tLsw = (laneMsw << (rhoOffset - 32)) | (laneLsw >>> (64 - rhoOffset));
                        }

                        // Transpose lanes
                        var TPiLane = T[PI_INDEXES[laneIndex]];
                        TPiLane.high = tMsw;
                        TPiLane.low  = tLsw;
                    }

                    // Rho pi at x = y = 0
                    var T0 = T[0];
                    var state0 = state[0];
                    T0.high = state0.high;
                    T0.low  = state0.low;

                    // Chi
                    for (var x = 0; x < 5; x++) {
                        for (var y = 0; y < 5; y++) {
                            // Shortcuts
                            var laneIndex = x + 5 * y;
                            var lane = state[laneIndex];
                            var TLane = T[laneIndex];
                            var Tx1Lane = T[((x + 1) % 5) + 5 * y];
                            var Tx2Lane = T[((x + 2) % 5) + 5 * y];

                            // Mix rows
                            lane.high = TLane.high ^ (~Tx1Lane.high & Tx2Lane.high);
                            lane.low  = TLane.low  ^ (~Tx1Lane.low  & Tx2Lane.low);
                        }
                    }

                    // Iota
                    var lane = state[0];
                    var roundConstant = ROUND_CONSTANTS[round];
                    lane.high ^= roundConstant.high;
                    lane.low  ^= roundConstant.low;;
                }
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;
                var blockSizeBits = this.blockSize * 32;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x1 << (24 - nBitsLeft % 32);
                dataWords[((Math.ceil((nBitsLeft + 1) / blockSizeBits) * blockSizeBits) >>> 5) - 1] |= 0x80;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var state = this._state;
                var outputLengthBytes = this.cfg.outputLength / 8;
                var outputLengthLanes = outputLengthBytes / 8;

                // Squeeze
                var hashWords = [];
                for (var i = 0; i < outputLengthLanes; i++) {
                    // Shortcuts
                    var lane = state[i];
                    var laneMsw = lane.high;
                    var laneLsw = lane.low;

                    // Swap endian
                    laneMsw = (
                        (((laneMsw << 8)  | (laneMsw >>> 24)) & 0x00ff00ff) |
                        (((laneMsw << 24) | (laneMsw >>> 8))  & 0xff00ff00)
                    );
                    laneLsw = (
                        (((laneLsw << 8)  | (laneLsw >>> 24)) & 0x00ff00ff) |
                        (((laneLsw << 24) | (laneLsw >>> 8))  & 0xff00ff00)
                    );

                    // Squeeze state to retrieve hash
                    hashWords.push(laneLsw);
                    hashWords.push(laneMsw);
                }

                // Return final computed hash
                return new WordArray.init(hashWords, outputLengthBytes);
            },

            clone: function () {
                var clone = Hasher.clone.call(this);

                var state = clone._state = this._state.slice(0);
                for (var i = 0; i < 25; i++) {
                    state[i] = state[i].clone();
                }

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA3('message');
         *     var hash = CryptoJS.SHA3(wordArray);
         */
        C.SHA3 = Hasher._createHelper(SHA3);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA3(message, key);
         */
        C.HmacSHA3 = Hasher._createHmacHelper(SHA3);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;

        function X64Word_create() {
            return X64Word.create.apply(X64Word, arguments);
        }

        // Constants
        var K = [
            X64Word_create(0x428a2f98, 0xd728ae22), X64Word_create(0x71374491, 0x23ef65cd),
            X64Word_create(0xb5c0fbcf, 0xec4d3b2f), X64Word_create(0xe9b5dba5, 0x8189dbbc),
            X64Word_create(0x3956c25b, 0xf348b538), X64Word_create(0x59f111f1, 0xb605d019),
            X64Word_create(0x923f82a4, 0xaf194f9b), X64Word_create(0xab1c5ed5, 0xda6d8118),
            X64Word_create(0xd807aa98, 0xa3030242), X64Word_create(0x12835b01, 0x45706fbe),
            X64Word_create(0x243185be, 0x4ee4b28c), X64Word_create(0x550c7dc3, 0xd5ffb4e2),
            X64Word_create(0x72be5d74, 0xf27b896f), X64Word_create(0x80deb1fe, 0x3b1696b1),
            X64Word_create(0x9bdc06a7, 0x25c71235), X64Word_create(0xc19bf174, 0xcf692694),
            X64Word_create(0xe49b69c1, 0x9ef14ad2), X64Word_create(0xefbe4786, 0x384f25e3),
            X64Word_create(0x0fc19dc6, 0x8b8cd5b5), X64Word_create(0x240ca1cc, 0x77ac9c65),
            X64Word_create(0x2de92c6f, 0x592b0275), X64Word_create(0x4a7484aa, 0x6ea6e483),
            X64Word_create(0x5cb0a9dc, 0xbd41fbd4), X64Word_create(0x76f988da, 0x831153b5),
            X64Word_create(0x983e5152, 0xee66dfab), X64Word_create(0xa831c66d, 0x2db43210),
            X64Word_create(0xb00327c8, 0x98fb213f), X64Word_create(0xbf597fc7, 0xbeef0ee4),
            X64Word_create(0xc6e00bf3, 0x3da88fc2), X64Word_create(0xd5a79147, 0x930aa725),
            X64Word_create(0x06ca6351, 0xe003826f), X64Word_create(0x14292967, 0x0a0e6e70),
            X64Word_create(0x27b70a85, 0x46d22ffc), X64Word_create(0x2e1b2138, 0x5c26c926),
            X64Word_create(0x4d2c6dfc, 0x5ac42aed), X64Word_create(0x53380d13, 0x9d95b3df),
            X64Word_create(0x650a7354, 0x8baf63de), X64Word_create(0x766a0abb, 0x3c77b2a8),
            X64Word_create(0x81c2c92e, 0x47edaee6), X64Word_create(0x92722c85, 0x1482353b),
            X64Word_create(0xa2bfe8a1, 0x4cf10364), X64Word_create(0xa81a664b, 0xbc423001),
            X64Word_create(0xc24b8b70, 0xd0f89791), X64Word_create(0xc76c51a3, 0x0654be30),
            X64Word_create(0xd192e819, 0xd6ef5218), X64Word_create(0xd6990624, 0x5565a910),
            X64Word_create(0xf40e3585, 0x5771202a), X64Word_create(0x106aa070, 0x32bbd1b8),
            X64Word_create(0x19a4c116, 0xb8d2d0c8), X64Word_create(0x1e376c08, 0x5141ab53),
            X64Word_create(0x2748774c, 0xdf8eeb99), X64Word_create(0x34b0bcb5, 0xe19b48a8),
            X64Word_create(0x391c0cb3, 0xc5c95a63), X64Word_create(0x4ed8aa4a, 0xe3418acb),
            X64Word_create(0x5b9cca4f, 0x7763e373), X64Word_create(0x682e6ff3, 0xd6b2b8a3),
            X64Word_create(0x748f82ee, 0x5defb2fc), X64Word_create(0x78a5636f, 0x43172f60),
            X64Word_create(0x84c87814, 0xa1f0ab72), X64Word_create(0x8cc70208, 0x1a6439ec),
            X64Word_create(0x90befffa, 0x23631e28), X64Word_create(0xa4506ceb, 0xde82bde9),
            X64Word_create(0xbef9a3f7, 0xb2c67915), X64Word_create(0xc67178f2, 0xe372532b),
            X64Word_create(0xca273ece, 0xea26619c), X64Word_create(0xd186b8c7, 0x21c0c207),
            X64Word_create(0xeada7dd6, 0xcde0eb1e), X64Word_create(0xf57d4f7f, 0xee6ed178),
            X64Word_create(0x06f067aa, 0x72176fba), X64Word_create(0x0a637dc5, 0xa2c898a6),
            X64Word_create(0x113f9804, 0xbef90dae), X64Word_create(0x1b710b35, 0x131c471b),
            X64Word_create(0x28db77f5, 0x23047d84), X64Word_create(0x32caab7b, 0x40c72493),
            X64Word_create(0x3c9ebe0a, 0x15c9bebc), X64Word_create(0x431d67c4, 0x9c100d4c),
            X64Word_create(0x4cc5d4be, 0xcb3e42b6), X64Word_create(0x597f299c, 0xfc657e2a),
            X64Word_create(0x5fcb6fab, 0x3ad6faec), X64Word_create(0x6c44198c, 0x4a475817)
        ];

        // Reusable objects
        var W = [];
        (function () {
            for (var i = 0; i < 80; i++) {
                W[i] = X64Word_create();
            }
        }());

        /**
         * SHA-512 hash algorithm.
         */
        var SHA512 = C_algo.SHA512 = Hasher.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0x6a09e667, 0xf3bcc908), new X64Word.init(0xbb67ae85, 0x84caa73b),
                    new X64Word.init(0x3c6ef372, 0xfe94f82b), new X64Word.init(0xa54ff53a, 0x5f1d36f1),
                    new X64Word.init(0x510e527f, 0xade682d1), new X64Word.init(0x9b05688c, 0x2b3e6c1f),
                    new X64Word.init(0x1f83d9ab, 0xfb41bd6b), new X64Word.init(0x5be0cd19, 0x137e2179)
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var H = this._hash.words;

                var H0 = H[0];
                var H1 = H[1];
                var H2 = H[2];
                var H3 = H[3];
                var H4 = H[4];
                var H5 = H[5];
                var H6 = H[6];
                var H7 = H[7];

                var H0h = H0.high;
                var H0l = H0.low;
                var H1h = H1.high;
                var H1l = H1.low;
                var H2h = H2.high;
                var H2l = H2.low;
                var H3h = H3.high;
                var H3l = H3.low;
                var H4h = H4.high;
                var H4l = H4.low;
                var H5h = H5.high;
                var H5l = H5.low;
                var H6h = H6.high;
                var H6l = H6.low;
                var H7h = H7.high;
                var H7l = H7.low;

                // Working variables
                var ah = H0h;
                var al = H0l;
                var bh = H1h;
                var bl = H1l;
                var ch = H2h;
                var cl = H2l;
                var dh = H3h;
                var dl = H3l;
                var eh = H4h;
                var el = H4l;
                var fh = H5h;
                var fl = H5l;
                var gh = H6h;
                var gl = H6l;
                var hh = H7h;
                var hl = H7l;

                // Rounds
                for (var i = 0; i < 80; i++) {
                    // Shortcut
                    var Wi = W[i];

                    // Extend message
                    if (i < 16) {
                        var Wih = Wi.high = M[offset + i * 2]     | 0;
                        var Wil = Wi.low  = M[offset + i * 2 + 1] | 0;
                    } else {
                        // Gamma0
                        var gamma0x  = W[i - 15];
                        var gamma0xh = gamma0x.high;
                        var gamma0xl = gamma0x.low;
                        var gamma0h  = ((gamma0xh >>> 1) | (gamma0xl << 31)) ^ ((gamma0xh >>> 8) | (gamma0xl << 24)) ^ (gamma0xh >>> 7);
                        var gamma0l  = ((gamma0xl >>> 1) | (gamma0xh << 31)) ^ ((gamma0xl >>> 8) | (gamma0xh << 24)) ^ ((gamma0xl >>> 7) | (gamma0xh << 25));

                        // Gamma1
                        var gamma1x  = W[i - 2];
                        var gamma1xh = gamma1x.high;
                        var gamma1xl = gamma1x.low;
                        var gamma1h  = ((gamma1xh >>> 19) | (gamma1xl << 13)) ^ ((gamma1xh << 3) | (gamma1xl >>> 29)) ^ (gamma1xh >>> 6);
                        var gamma1l  = ((gamma1xl >>> 19) | (gamma1xh << 13)) ^ ((gamma1xl << 3) | (gamma1xh >>> 29)) ^ ((gamma1xl >>> 6) | (gamma1xh << 26));

                        // W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16]
                        var Wi7  = W[i - 7];
                        var Wi7h = Wi7.high;
                        var Wi7l = Wi7.low;

                        var Wi16  = W[i - 16];
                        var Wi16h = Wi16.high;
                        var Wi16l = Wi16.low;

                        var Wil = gamma0l + Wi7l;
                        var Wih = gamma0h + Wi7h + ((Wil >>> 0) < (gamma0l >>> 0) ? 1 : 0);
                        var Wil = Wil + gamma1l;
                        var Wih = Wih + gamma1h + ((Wil >>> 0) < (gamma1l >>> 0) ? 1 : 0);
                        var Wil = Wil + Wi16l;
                        var Wih = Wih + Wi16h + ((Wil >>> 0) < (Wi16l >>> 0) ? 1 : 0);

                        Wi.high = Wih;
                        Wi.low  = Wil;
                    }

                    var chh  = (eh & fh) ^ (~eh & gh);
                    var chl  = (el & fl) ^ (~el & gl);
                    var majh = (ah & bh) ^ (ah & ch) ^ (bh & ch);
                    var majl = (al & bl) ^ (al & cl) ^ (bl & cl);

                    var sigma0h = ((ah >>> 28) | (al << 4))  ^ ((ah << 30)  | (al >>> 2)) ^ ((ah << 25) | (al >>> 7));
                    var sigma0l = ((al >>> 28) | (ah << 4))  ^ ((al << 30)  | (ah >>> 2)) ^ ((al << 25) | (ah >>> 7));
                    var sigma1h = ((eh >>> 14) | (el << 18)) ^ ((eh >>> 18) | (el << 14)) ^ ((eh << 23) | (el >>> 9));
                    var sigma1l = ((el >>> 14) | (eh << 18)) ^ ((el >>> 18) | (eh << 14)) ^ ((el << 23) | (eh >>> 9));

                    // t1 = h + sigma1 + ch + K[i] + W[i]
                    var Ki  = K[i];
                    var Kih = Ki.high;
                    var Kil = Ki.low;

                    var t1l = hl + sigma1l;
                    var t1h = hh + sigma1h + ((t1l >>> 0) < (hl >>> 0) ? 1 : 0);
                    var t1l = t1l + chl;
                    var t1h = t1h + chh + ((t1l >>> 0) < (chl >>> 0) ? 1 : 0);
                    var t1l = t1l + Kil;
                    var t1h = t1h + Kih + ((t1l >>> 0) < (Kil >>> 0) ? 1 : 0);
                    var t1l = t1l + Wil;
                    var t1h = t1h + Wih + ((t1l >>> 0) < (Wil >>> 0) ? 1 : 0);

                    // t2 = sigma0 + maj
                    var t2l = sigma0l + majl;
                    var t2h = sigma0h + majh + ((t2l >>> 0) < (sigma0l >>> 0) ? 1 : 0);

                    // Update working variables
                    hh = gh;
                    hl = gl;
                    gh = fh;
                    gl = fl;
                    fh = eh;
                    fl = el;
                    el = (dl + t1l) | 0;
                    eh = (dh + t1h + ((el >>> 0) < (dl >>> 0) ? 1 : 0)) | 0;
                    dh = ch;
                    dl = cl;
                    ch = bh;
                    cl = bl;
                    bh = ah;
                    bl = al;
                    al = (t1l + t2l) | 0;
                    ah = (t1h + t2h + ((al >>> 0) < (t1l >>> 0) ? 1 : 0)) | 0;
                }

                // Intermediate hash value
                H0l = H0.low  = (H0l + al);
                H0.high = (H0h + ah + ((H0l >>> 0) < (al >>> 0) ? 1 : 0));
                H1l = H1.low  = (H1l + bl);
                H1.high = (H1h + bh + ((H1l >>> 0) < (bl >>> 0) ? 1 : 0));
                H2l = H2.low  = (H2l + cl);
                H2.high = (H2h + ch + ((H2l >>> 0) < (cl >>> 0) ? 1 : 0));
                H3l = H3.low  = (H3l + dl);
                H3.high = (H3h + dh + ((H3l >>> 0) < (dl >>> 0) ? 1 : 0));
                H4l = H4.low  = (H4l + el);
                H4.high = (H4h + eh + ((H4l >>> 0) < (el >>> 0) ? 1 : 0));
                H5l = H5.low  = (H5l + fl);
                H5.high = (H5h + fh + ((H5l >>> 0) < (fl >>> 0) ? 1 : 0));
                H6l = H6.low  = (H6l + gl);
                H6.high = (H6h + gh + ((H6l >>> 0) < (gl >>> 0) ? 1 : 0));
                H7l = H7.low  = (H7l + hl);
                H7.high = (H7h + hh + ((H7l >>> 0) < (hl >>> 0) ? 1 : 0));
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 30] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 31] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Convert hash to 32-bit word array before returning
                var hash = this._hash.toX32();

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            },

            blockSize: 1024/32
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA512('message');
         *     var hash = CryptoJS.SHA512(wordArray);
         */
        C.SHA512 = Hasher._createHelper(SHA512);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA512(message, key);
         */
        C.HmacSHA512 = Hasher._createHmacHelper(SHA512);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;
        var SHA512 = C_algo.SHA512;

        /**
         * SHA-384 hash algorithm.
         */
        var SHA384 = C_algo.SHA384 = SHA512.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0xcbbb9d5d, 0xc1059ed8), new X64Word.init(0x629a292a, 0x367cd507),
                    new X64Word.init(0x9159015a, 0x3070dd17), new X64Word.init(0x152fecd8, 0xf70e5939),
                    new X64Word.init(0x67332667, 0xffc00b31), new X64Word.init(0x8eb44a87, 0x68581511),
                    new X64Word.init(0xdb0c2e0d, 0x64f98fa7), new X64Word.init(0x47b5481d, 0xbefa4fa4)
                ]);
            },

            _doFinalize: function () {
                var hash = SHA512._doFinalize.call(this);

                hash.sigBytes -= 16;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA384('message');
         *     var hash = CryptoJS.SHA384(wordArray);
         */
        C.SHA384 = SHA512._createHelper(SHA384);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA384(message, key);
         */
        C.HmacSHA384 = SHA512._createHmacHelper(SHA384);
    }());


    /**
     * Cipher core components.
     */
    CryptoJS.lib.Cipher || (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var Base64 = C_enc.Base64;
        var C_algo = C.algo;
        var EvpKDF = C_algo.EvpKDF;

        /**
         * Abstract base cipher template.
         *
         * @property {number} keySize This cipher's key size. Default: 4 (128 bits)
         * @property {number} ivSize This cipher's IV size. Default: 4 (128 bits)
         * @property {number} _ENC_XFORM_MODE A constant representing encryption mode.
         * @property {number} _DEC_XFORM_MODE A constant representing decryption mode.
         */
        var Cipher = C_lib.Cipher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             *
             * @property {WordArray} iv The IV to use for this operation.
             */
            cfg: Base.extend(),

            /**
             * Creates this cipher in encryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createEncryptor(keyWordArray, { iv: ivWordArray });
             */
            createEncryptor: function (key, cfg) {
                return this.create(this._ENC_XFORM_MODE, key, cfg);
            },

            /**
             * Creates this cipher in decryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createDecryptor(keyWordArray, { iv: ivWordArray });
             */
            createDecryptor: function (key, cfg) {
                return this.create(this._DEC_XFORM_MODE, key, cfg);
            },

            /**
             * Initializes a newly created cipher.
             *
             * @param {number} xformMode Either the encryption or decryption transormation mode constant.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.create(CryptoJS.algo.AES._ENC_XFORM_MODE, keyWordArray, { iv: ivWordArray });
             */
            init: function (xformMode, key, cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Store transform mode and key
                this._xformMode = xformMode;
                this._key = key;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this cipher to its initial state.
             *
             * @example
             *
             *     cipher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-cipher logic
                this._doReset();
            },

            /**
             * Adds data to be encrypted or decrypted.
             *
             * @param {WordArray|string} dataUpdate The data to encrypt or decrypt.
             *
             * @return {WordArray} The data after processing.
             *
             * @example
             *
             *     var encrypted = cipher.process('data');
             *     var encrypted = cipher.process(wordArray);
             */
            process: function (dataUpdate) {
                // Append
                this._append(dataUpdate);

                // Process available blocks
                return this._process();
            },

            /**
             * Finalizes the encryption or decryption process.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} dataUpdate The final data to encrypt or decrypt.
             *
             * @return {WordArray} The data after final processing.
             *
             * @example
             *
             *     var encrypted = cipher.finalize();
             *     var encrypted = cipher.finalize('data');
             *     var encrypted = cipher.finalize(wordArray);
             */
            finalize: function (dataUpdate) {
                // Final data update
                if (dataUpdate) {
                    this._append(dataUpdate);
                }

                // Perform concrete-cipher logic
                var finalProcessedData = this._doFinalize();

                return finalProcessedData;
            },

            keySize: 128/32,

            ivSize: 128/32,

            _ENC_XFORM_MODE: 1,

            _DEC_XFORM_MODE: 2,

            /**
             * Creates shortcut functions to a cipher's object interface.
             *
             * @param {Cipher} cipher The cipher to create a helper for.
             *
             * @return {Object} An object with encrypt and decrypt shortcut functions.
             *
             * @static
             *
             * @example
             *
             *     var AES = CryptoJS.lib.Cipher._createHelper(CryptoJS.algo.AES);
             */
            _createHelper: (function () {
                function selectCipherStrategy(key) {
                    if (typeof key == 'string') {
                        return PasswordBasedCipher;
                    } else {
                        return SerializableCipher;
                    }
                }

                return function (cipher) {
                    return {
                        encrypt: function (message, key, cfg) {
                            return selectCipherStrategy(key).encrypt(cipher, message, key, cfg);
                        },

                        decrypt: function (ciphertext, key, cfg) {
                            return selectCipherStrategy(key).decrypt(cipher, ciphertext, key, cfg);
                        }
                    };
                };
            }())
        });

        /**
         * Abstract base stream cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 1 (32 bits)
         */
        var StreamCipher = C_lib.StreamCipher = Cipher.extend({
            _doFinalize: function () {
                // Process partial blocks
                var finalProcessedBlocks = this._process(!!'flush');

                return finalProcessedBlocks;
            },

            blockSize: 1
        });

        /**
         * Mode namespace.
         */
        var C_mode = C.mode = {};

        /**
         * Abstract base block cipher mode template.
         */
        var BlockCipherMode = C_lib.BlockCipherMode = Base.extend({
            /**
             * Creates this mode for encryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createEncryptor(cipher, iv.words);
             */
            createEncryptor: function (cipher, iv) {
                return this.Encryptor.create(cipher, iv);
            },

            /**
             * Creates this mode for decryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createDecryptor(cipher, iv.words);
             */
            createDecryptor: function (cipher, iv) {
                return this.Decryptor.create(cipher, iv);
            },

            /**
             * Initializes a newly created mode.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.Encryptor.create(cipher, iv.words);
             */
            init: function (cipher, iv) {
                this._cipher = cipher;
                this._iv = iv;
            }
        });

        /**
         * Cipher Block Chaining mode.
         */
        var CBC = C_mode.CBC = (function () {
            /**
             * Abstract base CBC mode.
             */
            var CBC = BlockCipherMode.extend();

            /**
             * CBC encryptor.
             */
            CBC.Encryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // XOR and encrypt
                    xorBlock.call(this, words, offset, blockSize);
                    cipher.encryptBlock(words, offset);

                    // Remember this block to use with next block
                    this._prevBlock = words.slice(offset, offset + blockSize);
                }
            });

            /**
             * CBC decryptor.
             */
            CBC.Decryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // Remember this block to use with next block
                    var thisBlock = words.slice(offset, offset + blockSize);

                    // Decrypt and XOR
                    cipher.decryptBlock(words, offset);
                    xorBlock.call(this, words, offset, blockSize);

                    // This block becomes the previous block
                    this._prevBlock = thisBlock;
                }
            });

            function xorBlock(words, offset, blockSize) {
                // Shortcut
                var iv = this._iv;

                // Choose mixing block
                if (iv) {
                    var block = iv;

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                } else {
                    var block = this._prevBlock;
                }

                // XOR blocks
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= block[i];
                }
            }

            return CBC;
        }());

        /**
         * Padding namespace.
         */
        var C_pad = C.pad = {};

        /**
         * PKCS #5/7 padding strategy.
         */
        var Pkcs7 = C_pad.Pkcs7 = {
            /**
             * Pads data using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to pad.
             * @param {number} blockSize The multiple that the data should be padded to.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.pad(wordArray, 4);
             */
            pad: function (data, blockSize) {
                // Shortcut
                var blockSizeBytes = blockSize * 4;

                // Count padding bytes
                var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

                // Create padding word
                var paddingWord = (nPaddingBytes << 24) | (nPaddingBytes << 16) | (nPaddingBytes << 8) | nPaddingBytes;

                // Create padding
                var paddingWords = [];
                for (var i = 0; i < nPaddingBytes; i += 4) {
                    paddingWords.push(paddingWord);
                }
                var padding = WordArray.create(paddingWords, nPaddingBytes);

                // Add padding
                data.concat(padding);
            },

            /**
             * Unpads data that had been padded using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to unpad.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.unpad(wordArray);
             */
            unpad: function (data) {
                // Get number of padding bytes from last byte
                var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

                // Remove padding
                data.sigBytes -= nPaddingBytes;
            }
        };

        /**
         * Abstract base block cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 4 (128 bits)
         */
        var BlockCipher = C_lib.BlockCipher = Cipher.extend({
            /**
             * Configuration options.
             *
             * @property {Mode} mode The block mode to use. Default: CBC
             * @property {Padding} padding The padding strategy to use. Default: Pkcs7
             */
            cfg: Cipher.cfg.extend({
                mode: CBC,
                padding: Pkcs7
            }),

            reset: function () {
                // Reset cipher
                Cipher.reset.call(this);

                // Shortcuts
                var cfg = this.cfg;
                var iv = cfg.iv;
                var mode = cfg.mode;

                // Reset block mode
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    var modeCreator = mode.createEncryptor;
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    var modeCreator = mode.createDecryptor;
                    // Keep at least one block in the buffer for unpadding
                    this._minBufferSize = 1;
                }

                if (this._mode && this._mode.__creator == modeCreator) {
                    this._mode.init(this, iv && iv.words);
                } else {
                    this._mode = modeCreator.call(mode, this, iv && iv.words);
                    this._mode.__creator = modeCreator;
                }
            },

            _doProcessBlock: function (words, offset) {
                this._mode.processBlock(words, offset);
            },

            _doFinalize: function () {
                // Shortcut
                var padding = this.cfg.padding;

                // Finalize
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    // Pad data
                    padding.pad(this._data, this.blockSize);

                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');

                    // Unpad data
                    padding.unpad(finalProcessedBlocks);
                }

                return finalProcessedBlocks;
            },

            blockSize: 128/32
        });

        /**
         * A collection of cipher parameters.
         *
         * @property {WordArray} ciphertext The raw ciphertext.
         * @property {WordArray} key The key to this ciphertext.
         * @property {WordArray} iv The IV used in the ciphering operation.
         * @property {WordArray} salt The salt used with a key derivation function.
         * @property {Cipher} algorithm The cipher algorithm.
         * @property {Mode} mode The block mode used in the ciphering operation.
         * @property {Padding} padding The padding scheme used in the ciphering operation.
         * @property {number} blockSize The block size of the cipher.
         * @property {Format} formatter The default formatting strategy to convert this cipher params object to a string.
         */
        var CipherParams = C_lib.CipherParams = Base.extend({
            /**
             * Initializes a newly created cipher params object.
             *
             * @param {Object} cipherParams An object with any of the possible cipher parameters.
             *
             * @example
             *
             *     var cipherParams = CryptoJS.lib.CipherParams.create({
	         *         ciphertext: ciphertextWordArray,
	         *         key: keyWordArray,
	         *         iv: ivWordArray,
	         *         salt: saltWordArray,
	         *         algorithm: CryptoJS.algo.AES,
	         *         mode: CryptoJS.mode.CBC,
	         *         padding: CryptoJS.pad.PKCS7,
	         *         blockSize: 4,
	         *         formatter: CryptoJS.format.OpenSSL
	         *     });
             */
            init: function (cipherParams) {
                this.mixIn(cipherParams);
            },

            /**
             * Converts this cipher params object to a string.
             *
             * @param {Format} formatter (Optional) The formatting strategy to use.
             *
             * @return {string} The stringified cipher params.
             *
             * @throws Error If neither the formatter nor the default formatter is set.
             *
             * @example
             *
             *     var string = cipherParams + '';
             *     var string = cipherParams.toString();
             *     var string = cipherParams.toString(CryptoJS.format.OpenSSL);
             */
            toString: function (formatter) {
                return (formatter || this.formatter).stringify(this);
            }
        });

        /**
         * Format namespace.
         */
        var C_format = C.format = {};

        /**
         * OpenSSL formatting strategy.
         */
        var OpenSSLFormatter = C_format.OpenSSL = {
            /**
             * Converts a cipher params object to an OpenSSL-compatible string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The OpenSSL-compatible string.
             *
             * @static
             *
             * @example
             *
             *     var openSSLString = CryptoJS.format.OpenSSL.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                // Shortcuts
                var ciphertext = cipherParams.ciphertext;
                var salt = cipherParams.salt;

                // Format
                if (salt) {
                    var wordArray = WordArray.create([0x53616c74, 0x65645f5f]).concat(salt).concat(ciphertext);
                } else {
                    var wordArray = ciphertext;
                }

                return wordArray.toString(Base64);
            },

            /**
             * Converts an OpenSSL-compatible string to a cipher params object.
             *
             * @param {string} openSSLStr The OpenSSL-compatible string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.OpenSSL.parse(openSSLString);
             */
            parse: function (openSSLStr) {
                // Parse base64
                var ciphertext = Base64.parse(openSSLStr);

                // Shortcut
                var ciphertextWords = ciphertext.words;

                // Test for salt
                if (ciphertextWords[0] == 0x53616c74 && ciphertextWords[1] == 0x65645f5f) {
                    // Extract salt
                    var salt = WordArray.create(ciphertextWords.slice(2, 4));

                    // Remove salt from ciphertext
                    ciphertextWords.splice(0, 4);
                    ciphertext.sigBytes -= 16;
                }

                return CipherParams.create({ ciphertext: ciphertext, salt: salt });
            }
        };

        /**
         * A cipher wrapper that returns ciphertext as a serializable cipher params object.
         */
        var SerializableCipher = C_lib.SerializableCipher = Base.extend({
            /**
             * Configuration options.
             *
             * @property {Formatter} format The formatting strategy to convert cipher param objects to and from a string. Default: OpenSSL
             */
            cfg: Base.extend({
                format: OpenSSLFormatter
            }),

            /**
             * Encrypts a message.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key);
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv });
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Encrypt
                var encryptor = cipher.createEncryptor(key, cfg);
                var ciphertext = encryptor.finalize(message);

                // Shortcut
                var cipherCfg = encryptor.cfg;

                // Create and return serializable cipher params
                return CipherParams.create({
                    ciphertext: ciphertext,
                    key: key,
                    iv: cipherCfg.iv,
                    algorithm: cipher,
                    mode: cipherCfg.mode,
                    padding: cipherCfg.padding,
                    blockSize: cipher.blockSize,
                    formatter: cfg.format
                });
            },

            /**
             * Decrypts serialized ciphertext.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Decrypt
                var plaintext = cipher.createDecryptor(key, cfg).finalize(ciphertext.ciphertext);

                return plaintext;
            },

            /**
             * Converts serialized ciphertext to CipherParams,
             * else assumed CipherParams already and returns ciphertext unchanged.
             *
             * @param {CipherParams|string} ciphertext The ciphertext.
             * @param {Formatter} format The formatting strategy to use to parse serialized ciphertext.
             *
             * @return {CipherParams} The unserialized ciphertext.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher._parse(ciphertextStringOrParams, format);
             */
            _parse: function (ciphertext, format) {
                if (typeof ciphertext == 'string') {
                    return format.parse(ciphertext, this);
                } else {
                    return ciphertext;
                }
            }
        });

        /**
         * Key derivation function namespace.
         */
        var C_kdf = C.kdf = {};

        /**
         * OpenSSL key derivation function.
         */
        var OpenSSLKdf = C_kdf.OpenSSL = {
            /**
             * Derives a key and IV from a password.
             *
             * @param {string} password The password to derive from.
             * @param {number} keySize The size in words of the key to generate.
             * @param {number} ivSize The size in words of the IV to generate.
             * @param {WordArray|string} salt (Optional) A 64-bit salt to use. If omitted, a salt will be generated randomly.
             *
             * @return {CipherParams} A cipher params object with the key, IV, and salt.
             *
             * @static
             *
             * @example
             *
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32);
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32, 'saltsalt');
             */
            execute: function (password, keySize, ivSize, salt) {
                // Generate random salt
                if (!salt) {
                    salt = WordArray.random(64/8);
                }

                // Derive key and IV
                var key = EvpKDF.create({ keySize: keySize + ivSize }).compute(password, salt);

                // Separate key and IV
                var iv = WordArray.create(key.words.slice(keySize), ivSize * 4);
                key.sigBytes = keySize * 4;

                // Return params
                return CipherParams.create({ key: key, iv: iv, salt: salt });
            }
        };

        /**
         * A serializable cipher wrapper that derives the key from a password,
         * and returns ciphertext as a serializable cipher params object.
         */
        var PasswordBasedCipher = C_lib.PasswordBasedCipher = SerializableCipher.extend({
            /**
             * Configuration options.
             *
             * @property {KDF} kdf The key derivation function to use to generate a key and IV from a password. Default: OpenSSL
             */
            cfg: SerializableCipher.cfg.extend({
                kdf: OpenSSLKdf
            }),

            /**
             * Encrypts a message using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password');
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password', { format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Encrypt
                var ciphertext = SerializableCipher.encrypt.call(this, cipher, message, derivedParams.key, cfg);

                // Mix in derived params
                ciphertext.mixIn(derivedParams);

                return ciphertext;
            },

            /**
             * Decrypts serialized ciphertext using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, 'password', { format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, 'password', { format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize, ciphertext.salt);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Decrypt
                var plaintext = SerializableCipher.decrypt.call(this, cipher, ciphertext, derivedParams.key, cfg);

                return plaintext;
            }
        });
    }());


    /**
     * Cipher Feedback block mode.
     */
    CryptoJS.mode.CFB = (function () {
        var CFB = CryptoJS.lib.BlockCipherMode.extend();

        CFB.Encryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // Remember this block to use with next block
                this._prevBlock = words.slice(offset, offset + blockSize);
            }
        });

        CFB.Decryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                // Remember this block to use with next block
                var thisBlock = words.slice(offset, offset + blockSize);

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // This block becomes the previous block
                this._prevBlock = thisBlock;
            }
        });

        function generateKeystreamAndEncrypt(words, offset, blockSize, cipher) {
            // Shortcut
            var iv = this._iv;

            // Generate keystream
            if (iv) {
                var keystream = iv.slice(0);

                // Remove IV for subsequent blocks
                this._iv = undefined;
            } else {
                var keystream = this._prevBlock;
            }
            cipher.encryptBlock(keystream, 0);

            // Encrypt
            for (var i = 0; i < blockSize; i++) {
                words[offset + i] ^= keystream[i];
            }
        }

        return CFB;
    }());


    /**
     * Electronic Codebook block mode.
     */
    CryptoJS.mode.ECB = (function () {
        var ECB = CryptoJS.lib.BlockCipherMode.extend();

        ECB.Encryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.encryptBlock(words, offset);
            }
        });

        ECB.Decryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.decryptBlock(words, offset);
            }
        });

        return ECB;
    }());


    /**
     * ANSI X.923 padding strategy.
     */
    CryptoJS.pad.AnsiX923 = {
        pad: function (data, blockSize) {
            // Shortcuts
            var dataSigBytes = data.sigBytes;
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - dataSigBytes % blockSizeBytes;

            // Compute last byte position
            var lastBytePos = dataSigBytes + nPaddingBytes - 1;

            // Pad
            data.clamp();
            data.words[lastBytePos >>> 2] |= nPaddingBytes << (24 - (lastBytePos % 4) * 8);
            data.sigBytes += nPaddingBytes;
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO 10126 padding strategy.
     */
    CryptoJS.pad.Iso10126 = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

            // Pad
            data.concat(CryptoJS.lib.WordArray.random(nPaddingBytes - 1)).
            concat(CryptoJS.lib.WordArray.create([nPaddingBytes << 24], 1));
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO/IEC 9797-1 Padding Method 2.
     */
    CryptoJS.pad.Iso97971 = {
        pad: function (data, blockSize) {
            // Add 0x80 byte
            data.concat(CryptoJS.lib.WordArray.create([0x80000000], 1));

            // Zero pad the rest
            CryptoJS.pad.ZeroPadding.pad(data, blockSize);
        },

        unpad: function (data) {
            // Remove zero padding
            CryptoJS.pad.ZeroPadding.unpad(data);

            // Remove one more byte -- the 0x80 byte
            data.sigBytes--;
        }
    };


    /**
     * Output Feedback block mode.
     */
    CryptoJS.mode.OFB = (function () {
        var OFB = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = OFB.Encryptor = OFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var keystream = this._keystream;

                // Generate keystream
                if (iv) {
                    keystream = this._keystream = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        OFB.Decryptor = Encryptor;

        return OFB;
    }());


    /**
     * A noop padding strategy.
     */
    CryptoJS.pad.NoPadding = {
        pad: function () {
        },

        unpad: function () {
        }
    };


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var CipherParams = C_lib.CipherParams;
        var C_enc = C.enc;
        var Hex = C_enc.Hex;
        var C_format = C.format;

        var HexFormatter = C_format.Hex = {
            /**
             * Converts the ciphertext of a cipher params object to a hexadecimally encoded string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The hexadecimally encoded string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.format.Hex.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                return cipherParams.ciphertext.toString(Hex);
            },

            /**
             * Converts a hexadecimally encoded ciphertext string to a cipher params object.
             *
             * @param {string} input The hexadecimally encoded string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.Hex.parse(hexString);
             */
            parse: function (input) {
                var ciphertext = Hex.parse(input);
                return CipherParams.create({ ciphertext: ciphertext });
            }
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Lookup tables
        var SBOX = [];
        var INV_SBOX = [];
        var SUB_MIX_0 = [];
        var SUB_MIX_1 = [];
        var SUB_MIX_2 = [];
        var SUB_MIX_3 = [];
        var INV_SUB_MIX_0 = [];
        var INV_SUB_MIX_1 = [];
        var INV_SUB_MIX_2 = [];
        var INV_SUB_MIX_3 = [];

        // Compute lookup tables
        (function () {
            // Compute double table
            var d = [];
            for (var i = 0; i < 256; i++) {
                if (i < 128) {
                    d[i] = i << 1;
                } else {
                    d[i] = (i << 1) ^ 0x11b;
                }
            }

            // Walk GF(2^8)
            var x = 0;
            var xi = 0;
            for (var i = 0; i < 256; i++) {
                // Compute sbox
                var sx = xi ^ (xi << 1) ^ (xi << 2) ^ (xi << 3) ^ (xi << 4);
                sx = (sx >>> 8) ^ (sx & 0xff) ^ 0x63;
                SBOX[x] = sx;
                INV_SBOX[sx] = x;

                // Compute multiplication
                var x2 = d[x];
                var x4 = d[x2];
                var x8 = d[x4];

                // Compute sub bytes, mix columns tables
                var t = (d[sx] * 0x101) ^ (sx * 0x1010100);
                SUB_MIX_0[x] = (t << 24) | (t >>> 8);
                SUB_MIX_1[x] = (t << 16) | (t >>> 16);
                SUB_MIX_2[x] = (t << 8)  | (t >>> 24);
                SUB_MIX_3[x] = t;

                // Compute inv sub bytes, inv mix columns tables
                var t = (x8 * 0x1010101) ^ (x4 * 0x10001) ^ (x2 * 0x101) ^ (x * 0x1010100);
                INV_SUB_MIX_0[sx] = (t << 24) | (t >>> 8);
                INV_SUB_MIX_1[sx] = (t << 16) | (t >>> 16);
                INV_SUB_MIX_2[sx] = (t << 8)  | (t >>> 24);
                INV_SUB_MIX_3[sx] = t;

                // Compute next counter
                if (!x) {
                    x = xi = 1;
                } else {
                    x = x2 ^ d[d[d[x8 ^ x2]]];
                    xi ^= d[d[xi]];
                }
            }
        }());

        // Precomputed Rcon lookup
        var RCON = [0x00, 0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1b, 0x36];

        /**
         * AES block cipher algorithm.
         */
        var AES = C_algo.AES = BlockCipher.extend({
            _doReset: function () {
                // Skip reset of nRounds has been set before and key did not change
                if (this._nRounds && this._keyPriorReset === this._key) {
                    return;
                }

                // Shortcuts
                var key = this._keyPriorReset = this._key;
                var keyWords = key.words;
                var keySize = key.sigBytes / 4;

                // Compute number of rounds
                var nRounds = this._nRounds = keySize + 6;

                // Compute number of key schedule rows
                var ksRows = (nRounds + 1) * 4;

                // Compute key schedule
                var keySchedule = this._keySchedule = [];
                for (var ksRow = 0; ksRow < ksRows; ksRow++) {
                    if (ksRow < keySize) {
                        keySchedule[ksRow] = keyWords[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 1];

                        if (!(ksRow % keySize)) {
                            // Rot word
                            t = (t << 8) | (t >>> 24);

                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];

                            // Mix Rcon
                            t ^= RCON[(ksRow / keySize) | 0] << 24;
                        } else if (keySize > 6 && ksRow % keySize == 4) {
                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];
                        }

                        keySchedule[ksRow] = keySchedule[ksRow - keySize] ^ t;
                    }
                }

                // Compute inv key schedule
                var invKeySchedule = this._invKeySchedule = [];
                for (var invKsRow = 0; invKsRow < ksRows; invKsRow++) {
                    var ksRow = ksRows - invKsRow;

                    if (invKsRow % 4) {
                        var t = keySchedule[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 4];
                    }

                    if (invKsRow < 4 || ksRow <= 4) {
                        invKeySchedule[invKsRow] = t;
                    } else {
                        invKeySchedule[invKsRow] = INV_SUB_MIX_0[SBOX[t >>> 24]] ^ INV_SUB_MIX_1[SBOX[(t >>> 16) & 0xff]] ^
                            INV_SUB_MIX_2[SBOX[(t >>> 8) & 0xff]] ^ INV_SUB_MIX_3[SBOX[t & 0xff]];
                    }
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX);
            },

            decryptBlock: function (M, offset) {
                // Swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;

                this._doCryptBlock(M, offset, this._invKeySchedule, INV_SUB_MIX_0, INV_SUB_MIX_1, INV_SUB_MIX_2, INV_SUB_MIX_3, INV_SBOX);

                // Inv swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;
            },

            _doCryptBlock: function (M, offset, keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX) {
                // Shortcut
                var nRounds = this._nRounds;

                // Get input, add round key
                var s0 = M[offset]     ^ keySchedule[0];
                var s1 = M[offset + 1] ^ keySchedule[1];
                var s2 = M[offset + 2] ^ keySchedule[2];
                var s3 = M[offset + 3] ^ keySchedule[3];

                // Key schedule row counter
                var ksRow = 4;

                // Rounds
                for (var round = 1; round < nRounds; round++) {
                    // Shift rows, sub bytes, mix columns, add round key
                    var t0 = SUB_MIX_0[s0 >>> 24] ^ SUB_MIX_1[(s1 >>> 16) & 0xff] ^ SUB_MIX_2[(s2 >>> 8) & 0xff] ^ SUB_MIX_3[s3 & 0xff] ^ keySchedule[ksRow++];
                    var t1 = SUB_MIX_0[s1 >>> 24] ^ SUB_MIX_1[(s2 >>> 16) & 0xff] ^ SUB_MIX_2[(s3 >>> 8) & 0xff] ^ SUB_MIX_3[s0 & 0xff] ^ keySchedule[ksRow++];
                    var t2 = SUB_MIX_0[s2 >>> 24] ^ SUB_MIX_1[(s3 >>> 16) & 0xff] ^ SUB_MIX_2[(s0 >>> 8) & 0xff] ^ SUB_MIX_3[s1 & 0xff] ^ keySchedule[ksRow++];
                    var t3 = SUB_MIX_0[s3 >>> 24] ^ SUB_MIX_1[(s0 >>> 16) & 0xff] ^ SUB_MIX_2[(s1 >>> 8) & 0xff] ^ SUB_MIX_3[s2 & 0xff] ^ keySchedule[ksRow++];

                    // Update state
                    s0 = t0;
                    s1 = t1;
                    s2 = t2;
                    s3 = t3;
                }

                // Shift rows, sub bytes, add round key
                var t0 = ((SBOX[s0 >>> 24] << 24) | (SBOX[(s1 >>> 16) & 0xff] << 16) | (SBOX[(s2 >>> 8) & 0xff] << 8) | SBOX[s3 & 0xff]) ^ keySchedule[ksRow++];
                var t1 = ((SBOX[s1 >>> 24] << 24) | (SBOX[(s2 >>> 16) & 0xff] << 16) | (SBOX[(s3 >>> 8) & 0xff] << 8) | SBOX[s0 & 0xff]) ^ keySchedule[ksRow++];
                var t2 = ((SBOX[s2 >>> 24] << 24) | (SBOX[(s3 >>> 16) & 0xff] << 16) | (SBOX[(s0 >>> 8) & 0xff] << 8) | SBOX[s1 & 0xff]) ^ keySchedule[ksRow++];
                var t3 = ((SBOX[s3 >>> 24] << 24) | (SBOX[(s0 >>> 16) & 0xff] << 16) | (SBOX[(s1 >>> 8) & 0xff] << 8) | SBOX[s2 & 0xff]) ^ keySchedule[ksRow++];

                // Set output
                M[offset]     = t0;
                M[offset + 1] = t1;
                M[offset + 2] = t2;
                M[offset + 3] = t3;
            },

            keySize: 256/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.AES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.AES.decrypt(ciphertext, key, cfg);
         */
        C.AES = BlockCipher._createHelper(AES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Permuted Choice 1 constants
        var PC1 = [
            57, 49, 41, 33, 25, 17, 9,  1,
            58, 50, 42, 34, 26, 18, 10, 2,
            59, 51, 43, 35, 27, 19, 11, 3,
            60, 52, 44, 36, 63, 55, 47, 39,
            31, 23, 15, 7,  62, 54, 46, 38,
            30, 22, 14, 6,  61, 53, 45, 37,
            29, 21, 13, 5,  28, 20, 12, 4
        ];

        // Permuted Choice 2 constants
        var PC2 = [
            14, 17, 11, 24, 1,  5,
            3,  28, 15, 6,  21, 10,
            23, 19, 12, 4,  26, 8,
            16, 7,  27, 20, 13, 2,
            41, 52, 31, 37, 47, 55,
            30, 40, 51, 45, 33, 48,
            44, 49, 39, 56, 34, 53,
            46, 42, 50, 36, 29, 32
        ];

        // Cumulative bit shift constants
        var BIT_SHIFTS = [1,  2,  4,  6,  8,  10, 12, 14, 15, 17, 19, 21, 23, 25, 27, 28];

        // SBOXes and round permutation constants
        var SBOX_P = [
            {
                0x0: 0x808200,
                0x10000000: 0x8000,
                0x20000000: 0x808002,
                0x30000000: 0x2,
                0x40000000: 0x200,
                0x50000000: 0x808202,
                0x60000000: 0x800202,
                0x70000000: 0x800000,
                0x80000000: 0x202,
                0x90000000: 0x800200,
                0xa0000000: 0x8200,
                0xb0000000: 0x808000,
                0xc0000000: 0x8002,
                0xd0000000: 0x800002,
                0xe0000000: 0x0,
                0xf0000000: 0x8202,
                0x8000000: 0x0,
                0x18000000: 0x808202,
                0x28000000: 0x8202,
                0x38000000: 0x8000,
                0x48000000: 0x808200,
                0x58000000: 0x200,
                0x68000000: 0x808002,
                0x78000000: 0x2,
                0x88000000: 0x800200,
                0x98000000: 0x8200,
                0xa8000000: 0x808000,
                0xb8000000: 0x800202,
                0xc8000000: 0x800002,
                0xd8000000: 0x8002,
                0xe8000000: 0x202,
                0xf8000000: 0x800000,
                0x1: 0x8000,
                0x10000001: 0x2,
                0x20000001: 0x808200,
                0x30000001: 0x800000,
                0x40000001: 0x808002,
                0x50000001: 0x8200,
                0x60000001: 0x200,
                0x70000001: 0x800202,
                0x80000001: 0x808202,
                0x90000001: 0x808000,
                0xa0000001: 0x800002,
                0xb0000001: 0x8202,
                0xc0000001: 0x202,
                0xd0000001: 0x800200,
                0xe0000001: 0x8002,
                0xf0000001: 0x0,
                0x8000001: 0x808202,
                0x18000001: 0x808000,
                0x28000001: 0x800000,
                0x38000001: 0x200,
                0x48000001: 0x8000,
                0x58000001: 0x800002,
                0x68000001: 0x2,
                0x78000001: 0x8202,
                0x88000001: 0x8002,
                0x98000001: 0x800202,
                0xa8000001: 0x202,
                0xb8000001: 0x808200,
                0xc8000001: 0x800200,
                0xd8000001: 0x0,
                0xe8000001: 0x8200,
                0xf8000001: 0x808002
            },
            {
                0x0: 0x40084010,
                0x1000000: 0x4000,
                0x2000000: 0x80000,
                0x3000000: 0x40080010,
                0x4000000: 0x40000010,
                0x5000000: 0x40084000,
                0x6000000: 0x40004000,
                0x7000000: 0x10,
                0x8000000: 0x84000,
                0x9000000: 0x40004010,
                0xa000000: 0x40000000,
                0xb000000: 0x84010,
                0xc000000: 0x80010,
                0xd000000: 0x0,
                0xe000000: 0x4010,
                0xf000000: 0x40080000,
                0x800000: 0x40004000,
                0x1800000: 0x84010,
                0x2800000: 0x10,
                0x3800000: 0x40004010,
                0x4800000: 0x40084010,
                0x5800000: 0x40000000,
                0x6800000: 0x80000,
                0x7800000: 0x40080010,
                0x8800000: 0x80010,
                0x9800000: 0x0,
                0xa800000: 0x4000,
                0xb800000: 0x40080000,
                0xc800000: 0x40000010,
                0xd800000: 0x84000,
                0xe800000: 0x40084000,
                0xf800000: 0x4010,
                0x10000000: 0x0,
                0x11000000: 0x40080010,
                0x12000000: 0x40004010,
                0x13000000: 0x40084000,
                0x14000000: 0x40080000,
                0x15000000: 0x10,
                0x16000000: 0x84010,
                0x17000000: 0x4000,
                0x18000000: 0x4010,
                0x19000000: 0x80000,
                0x1a000000: 0x80010,
                0x1b000000: 0x40000010,
                0x1c000000: 0x84000,
                0x1d000000: 0x40004000,
                0x1e000000: 0x40000000,
                0x1f000000: 0x40084010,
                0x10800000: 0x84010,
                0x11800000: 0x80000,
                0x12800000: 0x40080000,
                0x13800000: 0x4000,
                0x14800000: 0x40004000,
                0x15800000: 0x40084010,
                0x16800000: 0x10,
                0x17800000: 0x40000000,
                0x18800000: 0x40084000,
                0x19800000: 0x40000010,
                0x1a800000: 0x40004010,
                0x1b800000: 0x80010,
                0x1c800000: 0x0,
                0x1d800000: 0x4010,
                0x1e800000: 0x40080010,
                0x1f800000: 0x84000
            },
            {
                0x0: 0x104,
                0x100000: 0x0,
                0x200000: 0x4000100,
                0x300000: 0x10104,
                0x400000: 0x10004,
                0x500000: 0x4000004,
                0x600000: 0x4010104,
                0x700000: 0x4010000,
                0x800000: 0x4000000,
                0x900000: 0x4010100,
                0xa00000: 0x10100,
                0xb00000: 0x4010004,
                0xc00000: 0x4000104,
                0xd00000: 0x10000,
                0xe00000: 0x4,
                0xf00000: 0x100,
                0x80000: 0x4010100,
                0x180000: 0x4010004,
                0x280000: 0x0,
                0x380000: 0x4000100,
                0x480000: 0x4000004,
                0x580000: 0x10000,
                0x680000: 0x10004,
                0x780000: 0x104,
                0x880000: 0x4,
                0x980000: 0x100,
                0xa80000: 0x4010000,
                0xb80000: 0x10104,
                0xc80000: 0x10100,
                0xd80000: 0x4000104,
                0xe80000: 0x4010104,
                0xf80000: 0x4000000,
                0x1000000: 0x4010100,
                0x1100000: 0x10004,
                0x1200000: 0x10000,
                0x1300000: 0x4000100,
                0x1400000: 0x100,
                0x1500000: 0x4010104,
                0x1600000: 0x4000004,
                0x1700000: 0x0,
                0x1800000: 0x4000104,
                0x1900000: 0x4000000,
                0x1a00000: 0x4,
                0x1b00000: 0x10100,
                0x1c00000: 0x4010000,
                0x1d00000: 0x104,
                0x1e00000: 0x10104,
                0x1f00000: 0x4010004,
                0x1080000: 0x4000000,
                0x1180000: 0x104,
                0x1280000: 0x4010100,
                0x1380000: 0x0,
                0x1480000: 0x10004,
                0x1580000: 0x4000100,
                0x1680000: 0x100,
                0x1780000: 0x4010004,
                0x1880000: 0x10000,
                0x1980000: 0x4010104,
                0x1a80000: 0x10104,
                0x1b80000: 0x4000004,
                0x1c80000: 0x4000104,
                0x1d80000: 0x4010000,
                0x1e80000: 0x4,
                0x1f80000: 0x10100
            },
            {
                0x0: 0x80401000,
                0x10000: 0x80001040,
                0x20000: 0x401040,
                0x30000: 0x80400000,
                0x40000: 0x0,
                0x50000: 0x401000,
                0x60000: 0x80000040,
                0x70000: 0x400040,
                0x80000: 0x80000000,
                0x90000: 0x400000,
                0xa0000: 0x40,
                0xb0000: 0x80001000,
                0xc0000: 0x80400040,
                0xd0000: 0x1040,
                0xe0000: 0x1000,
                0xf0000: 0x80401040,
                0x8000: 0x80001040,
                0x18000: 0x40,
                0x28000: 0x80400040,
                0x38000: 0x80001000,
                0x48000: 0x401000,
                0x58000: 0x80401040,
                0x68000: 0x0,
                0x78000: 0x80400000,
                0x88000: 0x1000,
                0x98000: 0x80401000,
                0xa8000: 0x400000,
                0xb8000: 0x1040,
                0xc8000: 0x80000000,
                0xd8000: 0x400040,
                0xe8000: 0x401040,
                0xf8000: 0x80000040,
                0x100000: 0x400040,
                0x110000: 0x401000,
                0x120000: 0x80000040,
                0x130000: 0x0,
                0x140000: 0x1040,
                0x150000: 0x80400040,
                0x160000: 0x80401000,
                0x170000: 0x80001040,
                0x180000: 0x80401040,
                0x190000: 0x80000000,
                0x1a0000: 0x80400000,
                0x1b0000: 0x401040,
                0x1c0000: 0x80001000,
                0x1d0000: 0x400000,
                0x1e0000: 0x40,
                0x1f0000: 0x1000,
                0x108000: 0x80400000,
                0x118000: 0x80401040,
                0x128000: 0x0,
                0x138000: 0x401000,
                0x148000: 0x400040,
                0x158000: 0x80000000,
                0x168000: 0x80001040,
                0x178000: 0x40,
                0x188000: 0x80000040,
                0x198000: 0x1000,
                0x1a8000: 0x80001000,
                0x1b8000: 0x80400040,
                0x1c8000: 0x1040,
                0x1d8000: 0x80401000,
                0x1e8000: 0x400000,
                0x1f8000: 0x401040
            },
            {
                0x0: 0x80,
                0x1000: 0x1040000,
                0x2000: 0x40000,
                0x3000: 0x20000000,
                0x4000: 0x20040080,
                0x5000: 0x1000080,
                0x6000: 0x21000080,
                0x7000: 0x40080,
                0x8000: 0x1000000,
                0x9000: 0x20040000,
                0xa000: 0x20000080,
                0xb000: 0x21040080,
                0xc000: 0x21040000,
                0xd000: 0x0,
                0xe000: 0x1040080,
                0xf000: 0x21000000,
                0x800: 0x1040080,
                0x1800: 0x21000080,
                0x2800: 0x80,
                0x3800: 0x1040000,
                0x4800: 0x40000,
                0x5800: 0x20040080,
                0x6800: 0x21040000,
                0x7800: 0x20000000,
                0x8800: 0x20040000,
                0x9800: 0x0,
                0xa800: 0x21040080,
                0xb800: 0x1000080,
                0xc800: 0x20000080,
                0xd800: 0x21000000,
                0xe800: 0x1000000,
                0xf800: 0x40080,
                0x10000: 0x40000,
                0x11000: 0x80,
                0x12000: 0x20000000,
                0x13000: 0x21000080,
                0x14000: 0x1000080,
                0x15000: 0x21040000,
                0x16000: 0x20040080,
                0x17000: 0x1000000,
                0x18000: 0x21040080,
                0x19000: 0x21000000,
                0x1a000: 0x1040000,
                0x1b000: 0x20040000,
                0x1c000: 0x40080,
                0x1d000: 0x20000080,
                0x1e000: 0x0,
                0x1f000: 0x1040080,
                0x10800: 0x21000080,
                0x11800: 0x1000000,
                0x12800: 0x1040000,
                0x13800: 0x20040080,
                0x14800: 0x20000000,
                0x15800: 0x1040080,
                0x16800: 0x80,
                0x17800: 0x21040000,
                0x18800: 0x40080,
                0x19800: 0x21040080,
                0x1a800: 0x0,
                0x1b800: 0x21000000,
                0x1c800: 0x1000080,
                0x1d800: 0x40000,
                0x1e800: 0x20040000,
                0x1f800: 0x20000080
            },
            {
                0x0: 0x10000008,
                0x100: 0x2000,
                0x200: 0x10200000,
                0x300: 0x10202008,
                0x400: 0x10002000,
                0x500: 0x200000,
                0x600: 0x200008,
                0x700: 0x10000000,
                0x800: 0x0,
                0x900: 0x10002008,
                0xa00: 0x202000,
                0xb00: 0x8,
                0xc00: 0x10200008,
                0xd00: 0x202008,
                0xe00: 0x2008,
                0xf00: 0x10202000,
                0x80: 0x10200000,
                0x180: 0x10202008,
                0x280: 0x8,
                0x380: 0x200000,
                0x480: 0x202008,
                0x580: 0x10000008,
                0x680: 0x10002000,
                0x780: 0x2008,
                0x880: 0x200008,
                0x980: 0x2000,
                0xa80: 0x10002008,
                0xb80: 0x10200008,
                0xc80: 0x0,
                0xd80: 0x10202000,
                0xe80: 0x202000,
                0xf80: 0x10000000,
                0x1000: 0x10002000,
                0x1100: 0x10200008,
                0x1200: 0x10202008,
                0x1300: 0x2008,
                0x1400: 0x200000,
                0x1500: 0x10000000,
                0x1600: 0x10000008,
                0x1700: 0x202000,
                0x1800: 0x202008,
                0x1900: 0x0,
                0x1a00: 0x8,
                0x1b00: 0x10200000,
                0x1c00: 0x2000,
                0x1d00: 0x10002008,
                0x1e00: 0x10202000,
                0x1f00: 0x200008,
                0x1080: 0x8,
                0x1180: 0x202000,
                0x1280: 0x200000,
                0x1380: 0x10000008,
                0x1480: 0x10002000,
                0x1580: 0x2008,
                0x1680: 0x10202008,
                0x1780: 0x10200000,
                0x1880: 0x10202000,
                0x1980: 0x10200008,
                0x1a80: 0x2000,
                0x1b80: 0x202008,
                0x1c80: 0x200008,
                0x1d80: 0x0,
                0x1e80: 0x10000000,
                0x1f80: 0x10002008
            },
            {
                0x0: 0x100000,
                0x10: 0x2000401,
                0x20: 0x400,
                0x30: 0x100401,
                0x40: 0x2100401,
                0x50: 0x0,
                0x60: 0x1,
                0x70: 0x2100001,
                0x80: 0x2000400,
                0x90: 0x100001,
                0xa0: 0x2000001,
                0xb0: 0x2100400,
                0xc0: 0x2100000,
                0xd0: 0x401,
                0xe0: 0x100400,
                0xf0: 0x2000000,
                0x8: 0x2100001,
                0x18: 0x0,
                0x28: 0x2000401,
                0x38: 0x2100400,
                0x48: 0x100000,
                0x58: 0x2000001,
                0x68: 0x2000000,
                0x78: 0x401,
                0x88: 0x100401,
                0x98: 0x2000400,
                0xa8: 0x2100000,
                0xb8: 0x100001,
                0xc8: 0x400,
                0xd8: 0x2100401,
                0xe8: 0x1,
                0xf8: 0x100400,
                0x100: 0x2000000,
                0x110: 0x100000,
                0x120: 0x2000401,
                0x130: 0x2100001,
                0x140: 0x100001,
                0x150: 0x2000400,
                0x160: 0x2100400,
                0x170: 0x100401,
                0x180: 0x401,
                0x190: 0x2100401,
                0x1a0: 0x100400,
                0x1b0: 0x1,
                0x1c0: 0x0,
                0x1d0: 0x2100000,
                0x1e0: 0x2000001,
                0x1f0: 0x400,
                0x108: 0x100400,
                0x118: 0x2000401,
                0x128: 0x2100001,
                0x138: 0x1,
                0x148: 0x2000000,
                0x158: 0x100000,
                0x168: 0x401,
                0x178: 0x2100400,
                0x188: 0x2000001,
                0x198: 0x2100000,
                0x1a8: 0x0,
                0x1b8: 0x2100401,
                0x1c8: 0x100401,
                0x1d8: 0x400,
                0x1e8: 0x2000400,
                0x1f8: 0x100001
            },
            {
                0x0: 0x8000820,
                0x1: 0x20000,
                0x2: 0x8000000,
                0x3: 0x20,
                0x4: 0x20020,
                0x5: 0x8020820,
                0x6: 0x8020800,
                0x7: 0x800,
                0x8: 0x8020000,
                0x9: 0x8000800,
                0xa: 0x20800,
                0xb: 0x8020020,
                0xc: 0x820,
                0xd: 0x0,
                0xe: 0x8000020,
                0xf: 0x20820,
                0x80000000: 0x800,
                0x80000001: 0x8020820,
                0x80000002: 0x8000820,
                0x80000003: 0x8000000,
                0x80000004: 0x8020000,
                0x80000005: 0x20800,
                0x80000006: 0x20820,
                0x80000007: 0x20,
                0x80000008: 0x8000020,
                0x80000009: 0x820,
                0x8000000a: 0x20020,
                0x8000000b: 0x8020800,
                0x8000000c: 0x0,
                0x8000000d: 0x8020020,
                0x8000000e: 0x8000800,
                0x8000000f: 0x20000,
                0x10: 0x20820,
                0x11: 0x8020800,
                0x12: 0x20,
                0x13: 0x800,
                0x14: 0x8000800,
                0x15: 0x8000020,
                0x16: 0x8020020,
                0x17: 0x20000,
                0x18: 0x0,
                0x19: 0x20020,
                0x1a: 0x8020000,
                0x1b: 0x8000820,
                0x1c: 0x8020820,
                0x1d: 0x20800,
                0x1e: 0x820,
                0x1f: 0x8000000,
                0x80000010: 0x20000,
                0x80000011: 0x800,
                0x80000012: 0x8020020,
                0x80000013: 0x20820,
                0x80000014: 0x20,
                0x80000015: 0x8020000,
                0x80000016: 0x8000000,
                0x80000017: 0x8000820,
                0x80000018: 0x8020820,
                0x80000019: 0x8000020,
                0x8000001a: 0x8000800,
                0x8000001b: 0x0,
                0x8000001c: 0x20800,
                0x8000001d: 0x820,
                0x8000001e: 0x20020,
                0x8000001f: 0x8020800
            }
        ];

        // Masks that select the SBOX input
        var SBOX_MASK = [
            0xf8000001, 0x1f800000, 0x01f80000, 0x001f8000,
            0x0001f800, 0x00001f80, 0x000001f8, 0x8000001f
        ];

        /**
         * DES block cipher algorithm.
         */
        var DES = C_algo.DES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Select 56 bits according to PC1
                var keyBits = [];
                for (var i = 0; i < 56; i++) {
                    var keyBitPos = PC1[i] - 1;
                    keyBits[i] = (keyWords[keyBitPos >>> 5] >>> (31 - keyBitPos % 32)) & 1;
                }

                // Assemble 16 subkeys
                var subKeys = this._subKeys = [];
                for (var nSubKey = 0; nSubKey < 16; nSubKey++) {
                    // Create subkey
                    var subKey = subKeys[nSubKey] = [];

                    // Shortcut
                    var bitShift = BIT_SHIFTS[nSubKey];

                    // Select 48 bits according to PC2
                    for (var i = 0; i < 24; i++) {
                        // Select from the left 28 key bits
                        subKey[(i / 6) | 0] |= keyBits[((PC2[i] - 1) + bitShift) % 28] << (31 - i % 6);

                        // Select from the right 28 key bits
                        subKey[4 + ((i / 6) | 0)] |= keyBits[28 + (((PC2[i + 24] - 1) + bitShift) % 28)] << (31 - i % 6);
                    }

                    // Since each subkey is applied to an expanded 32-bit input,
                    // the subkey can be broken into 8 values scaled to 32-bits,
                    // which allows the key to be used without expansion
                    subKey[0] = (subKey[0] << 1) | (subKey[0] >>> 31);
                    for (var i = 1; i < 7; i++) {
                        subKey[i] = subKey[i] >>> ((i - 1) * 4 + 3);
                    }
                    subKey[7] = (subKey[7] << 5) | (subKey[7] >>> 27);
                }

                // Compute inverse subkeys
                var invSubKeys = this._invSubKeys = [];
                for (var i = 0; i < 16; i++) {
                    invSubKeys[i] = subKeys[15 - i];
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._subKeys);
            },

            decryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._invSubKeys);
            },

            _doCryptBlock: function (M, offset, subKeys) {
                // Get input
                this._lBlock = M[offset];
                this._rBlock = M[offset + 1];

                // Initial permutation
                exchangeLR.call(this, 4,  0x0f0f0f0f);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeLR.call(this, 1,  0x55555555);

                // Rounds
                for (var round = 0; round < 16; round++) {
                    // Shortcuts
                    var subKey = subKeys[round];
                    var lBlock = this._lBlock;
                    var rBlock = this._rBlock;

                    // Feistel function
                    var f = 0;
                    for (var i = 0; i < 8; i++) {
                        f |= SBOX_P[i][((rBlock ^ subKey[i]) & SBOX_MASK[i]) >>> 0];
                    }
                    this._lBlock = rBlock;
                    this._rBlock = lBlock ^ f;
                }

                // Undo swap from last round
                var t = this._lBlock;
                this._lBlock = this._rBlock;
                this._rBlock = t;

                // Final permutation
                exchangeLR.call(this, 1,  0x55555555);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeLR.call(this, 4,  0x0f0f0f0f);

                // Set output
                M[offset] = this._lBlock;
                M[offset + 1] = this._rBlock;
            },

            keySize: 64/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        // Swap bits across the left and right words
        function exchangeLR(offset, mask) {
            var t = ((this._lBlock >>> offset) ^ this._rBlock) & mask;
            this._rBlock ^= t;
            this._lBlock ^= t << offset;
        }

        function exchangeRL(offset, mask) {
            var t = ((this._rBlock >>> offset) ^ this._lBlock) & mask;
            this._lBlock ^= t;
            this._rBlock ^= t << offset;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.DES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.DES.decrypt(ciphertext, key, cfg);
         */
        C.DES = BlockCipher._createHelper(DES);

        /**
         * Triple-DES block cipher algorithm.
         */
        var TripleDES = C_algo.TripleDES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Create DES instances
                this._des1 = DES.createEncryptor(WordArray.create(keyWords.slice(0, 2)));
                this._des2 = DES.createEncryptor(WordArray.create(keyWords.slice(2, 4)));
                this._des3 = DES.createEncryptor(WordArray.create(keyWords.slice(4, 6)));
            },

            encryptBlock: function (M, offset) {
                this._des1.encryptBlock(M, offset);
                this._des2.decryptBlock(M, offset);
                this._des3.encryptBlock(M, offset);
            },

            decryptBlock: function (M, offset) {
                this._des3.decryptBlock(M, offset);
                this._des2.encryptBlock(M, offset);
                this._des1.decryptBlock(M, offset);
            },

            keySize: 192/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.TripleDES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.TripleDES.decrypt(ciphertext, key, cfg);
         */
        C.TripleDES = BlockCipher._createHelper(TripleDES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        /**
         * RC4 stream cipher algorithm.
         */
        var RC4 = C_algo.RC4 = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;
                var keySigBytes = key.sigBytes;

                // Init sbox
                var S = this._S = [];
                for (var i = 0; i < 256; i++) {
                    S[i] = i;
                }

                // Key setup
                for (var i = 0, j = 0; i < 256; i++) {
                    var keyByteIndex = i % keySigBytes;
                    var keyByte = (keyWords[keyByteIndex >>> 2] >>> (24 - (keyByteIndex % 4) * 8)) & 0xff;

                    j = (j + S[i] + keyByte) % 256;

                    // Swap
                    var t = S[i];
                    S[i] = S[j];
                    S[j] = t;
                }

                // Counters
                this._i = this._j = 0;
            },

            _doProcessBlock: function (M, offset) {
                M[offset] ^= generateKeystreamWord.call(this);
            },

            keySize: 256/32,

            ivSize: 0
        });

        function generateKeystreamWord() {
            // Shortcuts
            var S = this._S;
            var i = this._i;
            var j = this._j;

            // Generate keystream word
            var keystreamWord = 0;
            for (var n = 0; n < 4; n++) {
                i = (i + 1) % 256;
                j = (j + S[i]) % 256;

                // Swap
                var t = S[i];
                S[i] = S[j];
                S[j] = t;

                keystreamWord |= S[(S[i] + S[j]) % 256] << (24 - n * 8);
            }

            // Update counters
            this._i = i;
            this._j = j;

            return keystreamWord;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4.decrypt(ciphertext, key, cfg);
         */
        C.RC4 = StreamCipher._createHelper(RC4);

        /**
         * Modified RC4 stream cipher algorithm.
         */
        var RC4Drop = C_algo.RC4Drop = RC4.extend({
            /**
             * Configuration options.
             *
             * @property {number} drop The number of keystream words to drop. Default 192
             */
            cfg: RC4.cfg.extend({
                drop: 192
            }),

            _doReset: function () {
                RC4._doReset.call(this);

                // Drop
                for (var i = this.cfg.drop; i > 0; i--) {
                    generateKeystreamWord.call(this);
                }
            }
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4Drop.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4Drop.decrypt(ciphertext, key, cfg);
         */
        C.RC4Drop = StreamCipher._createHelper(RC4Drop);
    }());


    /** @preserve
     * Counter block mode compatible with  Dr Brian Gladman fileenc.c
     * derived from CryptoJS.mode.CTR
     * Jan Hruby jhruby.web@gmail.com
     */
    CryptoJS.mode.CTRGladman = (function () {
        var CTRGladman = CryptoJS.lib.BlockCipherMode.extend();

        function incWord(word)
        {
            if (((word >> 24) & 0xff) === 0xff) { //overflow
                var b1 = (word >> 16)&0xff;
                var b2 = (word >> 8)&0xff;
                var b3 = word & 0xff;

                if (b1 === 0xff) // overflow b1
                {
                    b1 = 0;
                    if (b2 === 0xff)
                    {
                        b2 = 0;
                        if (b3 === 0xff)
                        {
                            b3 = 0;
                        }
                        else
                        {
                            ++b3;
                        }
                    }
                    else
                    {
                        ++b2;
                    }
                }
                else
                {
                    ++b1;
                }

                word = 0;
                word += (b1 << 16);
                word += (b2 << 8);
                word += b3;
            }
            else
            {
                word += (0x01 << 24);
            }
            return word;
        }

        function incCounter(counter)
        {
            if ((counter[0] = incWord(counter[0])) === 0)
            {
                // encr_data in fileenc.c from  Dr Brian Gladman's counts only with DWORD j < 8
                counter[1] = incWord(counter[1]);
            }
            return counter;
        }

        var Encryptor = CTRGladman.Encryptor = CTRGladman.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }

                incCounter(counter);

                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTRGladman.Decryptor = Encryptor;

        return CTRGladman;
    }());




    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm
         */
        var Rabbit = C_algo.Rabbit = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    K[i] = (((K[i] << 8)  | (K[i] >>> 24)) & 0x00ff00ff) |
                        (((K[i] << 24) | (K[i] >>> 8))  & 0xff00ff00);
                }

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.Rabbit.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.Rabbit.decrypt(ciphertext, key, cfg);
         */
        C.Rabbit = StreamCipher._createHelper(Rabbit);
    }());


    /**
     * Counter block mode.
     */
    CryptoJS.mode.CTR = (function () {
        var CTR = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = CTR.Encryptor = CTR.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Increment counter
                counter[blockSize - 1] = (counter[blockSize - 1] + 1) | 0

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTR.Decryptor = Encryptor;

        return CTR;
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm.
         *
         * This is a legacy version that neglected to convert the key to little-endian.
         * This error doesn't affect the cipher's security,
         * but it does affect its compatibility with other implementations.
         */
        var RabbitLegacy = C_algo.RabbitLegacy = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RabbitLegacy.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RabbitLegacy.decrypt(ciphertext, key, cfg);
         */
        C.RabbitLegacy = StreamCipher._createHelper(RabbitLegacy);
    }());


    /**
     * Zero padding strategy.
     */
    CryptoJS.pad.ZeroPadding = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Pad
            data.clamp();
            data.sigBytes += blockSizeBytes - ((data.sigBytes % blockSizeBytes) || blockSizeBytes);
        },

        unpad: function (data) {
            // Shortcut
            var dataWords = data.words;

            // Unpad
            var i = data.sigBytes - 1;
            while (!((dataWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff)) {
                i--;
            }
            data.sigBytes = i + 1;
        }
    };


    return CryptoJS;

}));</script>

<script>
    // variables to be filled when generating the file
    var encryptedMsg = '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',
        salt = 'ca879b013dfb115d4a0275c0568281ec',
        isRememberEnabled = true,
        rememberDurationInDays = 0; // 0 means forever

    // constants
    var rememberPassphraseKey = 'staticrypt_passphrase',
        rememberExpirationKey = 'staticrypt_expiration';

    /**
     * Decrypt a salted msg using a password.
     * Inspired by https://github.com/adonespitogo
     *
     * @param  encryptedMsg
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptMsg(encryptedMsg, hashedPassphrase) {
        var iv = CryptoJS.enc.Hex.parse(encryptedMsg.substr(0, 32))
        var encrypted = encryptedMsg.substring(32);

        return CryptoJS.AES.decrypt(encrypted, hashedPassphrase, {
            iv: iv,
            padding: CryptoJS.pad.Pkcs7,
            mode: CryptoJS.mode.CBC
        }).toString(CryptoJS.enc.Utf8);
    }

    /**
     * Decrypt our encrypted page, replace the whole HTML.
     *
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptAndReplaceHtml(hashedPassphrase) {
        var encryptedHMAC = encryptedMsg.substring(0, 64),
            encryptedHTML = encryptedMsg.substring(64),
            decryptedHMAC = CryptoJS.HmacSHA256(encryptedHTML, CryptoJS.SHA256(hashedPassphrase).toString()).toString();

        if (decryptedHMAC !== encryptedHMAC) {
            return false;
        }

        var plainHTML = decryptMsg(encryptedHTML, hashedPassphrase);

        document.write(plainHTML);
        document.close();

        return true;
    }

    /**
     * Salt and hash the passphrase so it can be stored in localStorage without opening a password reuse vulnerability.
     *
     * @param  passphrase
     * @returns 
     */
    function hashPassphrase(passphrase) {
        return CryptoJS.PBKDF2(passphrase, salt, {
            keySize: 256 / 32,
            iterations: 1000
        }).toString();
    }

    /**
     * Clear localstorage from staticrypt related values
     */
    function clearLocalStorage() {
        localStorage.removeItem(rememberPassphraseKey);
        localStorage.removeItem(rememberExpirationKey);
    }

    // try to automatically decrypt on load if there is a saved password
    window.onload = function () {
        if (isRememberEnabled) {
            // show the remember me checkbox
            document.getElementById('staticrypt-remember-label').classList.remove('hidden');

            // if we are login out, clear the storage and terminate
            var queryParams = new URLSearchParams(window.location.search);

            if (queryParams.has("staticrypt_logout")) {
                return clearLocalStorage();
            }

            // if there is expiration configured, check if we're not beyond the expiration
            if (rememberDurationInDays && rememberDurationInDays > 0) {
                var expiration = localStorage.getItem(rememberExpirationKey),
                    isExpired = expiration && new Date().getTime() > parseInt(expiration);

                if (isExpired) {
                    return clearLocalStorage();
                }
            }

            var hashedPassphrase = localStorage.getItem(rememberPassphraseKey);

            if (hashedPassphrase) {
                // try to decrypt
                var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

                // if the decryption is unsuccessful the password might be wrong - silently clear the saved data and let
                // the user fill the password form again
                if (!isDecryptionSuccessful) {
                    return clearLocalStorage();
                }
            }
        }
    }

    // handle password form submission
    document.getElementById('staticrypt-form').addEventListener('submit', function (e) {
        e.preventDefault();

        var passphrase = document.getElementById('staticrypt-password').value,
            shouldRememberPassphrase = document.getElementById('staticrypt-remember').checked;

        // decrypt and replace the whole page
        var hashedPassphrase = hashPassphrase(passphrase);
        var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

        if (isDecryptionSuccessful) {
            // remember the hashedPassphrase and set its expiration if necessary
            if (isRememberEnabled && shouldRememberPassphrase) {
                window.localStorage.setItem(rememberPassphraseKey, hashedPassphrase);

                // set the expiration if the duration isn't 0 (meaning no expiration)
                if (rememberDurationInDays > 0) {
                    window.localStorage.setItem(
                        rememberExpirationKey,
                        (new Date().getTime() + rememberDurationInDays * 24 * 60 * 60 * 1000).toString()
                    );
                }
            }
        } else {
            alert('Bad passphrase!');
        }
    });
</script>
</body>
</html>
